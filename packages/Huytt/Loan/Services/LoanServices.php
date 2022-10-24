<?php
namespace Huytt\Loan\Services;

use Huytt\Core\Repository\Criteria\RequestCriteria;
use Huytt\Loan\Contracts\Loan;
use Huytt\Loan\Contracts\ScheduledPayment;
use Huytt\Loan\Http\Requests\LoanCreateRequest;
use Huytt\Loan\Repositories\LoanRepository;
use Huytt\Loan\Repositories\ScheduledPaymentsRepository;
use Huytt\Loan\Contracts\Loan as LoanContract;
use Huytt\Loan\Contracts\ScheduledPayment as ScheduledPaymentContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class LoanServices
{
    protected $with = [
        'scheduledPayments'
    ];

    /** @var LoanRepository */
    protected $loanRepo;

    /** @var ScheduledPaymentsRepository */
    protected $scheduledPaymentRepo;

    public function __construct(LoanRepository $loanRepo, ScheduledPaymentsRepository $scheduledPaymentRepo)
    {
        $this->loanRepo = $loanRepo;
        $this->scheduledPaymentRepo = $scheduledPaymentRepo;
    }

    /**
     * @param LoanCreateRequest $request
     * @return LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     */
    public function store(LoanCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->only(['amount', 'term']);
            $loan = $this->loanRepo->create(array_merge($params, [
                'status' => LoanContract::LOAN_STATUS_PENDING,
                'frequency' => LoanContract::FREQUENCY,
                'user_id' => auth()->user()->id
            ]));

            $scheduledPaymentAmount = ($params['amount'] / $params['term']);

            $schedulePaymentArr = [
                'date'      => Carbon::now(),
                'loan_id'   => $loan->id,
                'amount'    => $scheduledPaymentAmount,
                'status'    => ScheduledPaymentContract::SCHEDULED_PAYMENT_STATUS_PENDING
            ];
            $schedulePaymentCreateArr = [];

            for ($i = 0; $i < $params['term']; $i++) {
                $schedulePaymentArr['date'] = Carbon::parse($schedulePaymentArr['date'])->addDays(7);
                $schedulePaymentArr['id'] = (string)Str::uuid();
                $schedulePaymentCreateArr[] = $schedulePaymentArr;
            }

            $this->scheduledPaymentRepo->upsert($schedulePaymentCreateArr, ['id']);
            DB::commit();

            return $loan;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @return LengthAwarePaginator|Collection|mixed
     * @throws RepositoryException
     */
    public function meList(): mixed
    {
        $params = request()->input();
        $perPage = isset($params['limit']) && ! empty($params['limit']) ? $params['limit'] : 50;
        $this->loanRepo->pushCriteria(app(RequestCriteria::class));
        return $this->loanRepo->meList($this->with)->paginate($perPage);
    }

    public function approve($id) {
        if(!auth('admin-api')->check()) {
            throw new Exception('Unauthorized', 401);
        }

        /** @var \Huytt\Loan\Models\Loan $loan */
        $loan = $this->loanRepo->getById($id);

        if($loan->status != Loan::LOAN_STATUS_PENDING) {
            throw new Exception('Loan must have status pending', 400);
        }

        try {
            DB::beginTransaction();
            /** @var \Huytt\Loan\Models\Loan $loan */
            $loan = $this->loanRepo->with($this->with)->update(['status' => Loan::LOAN_STATUS_APPROVE], $id);
            $loan->scheduledPayments()->update(['status' => ScheduledPayment::SCHEDULED_PAYMENT_STATUS_APPROVE]);
            DB::commit();
            return $loan;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $scheduleId
     * @param $amount
     * @return void
     * @throws ValidatorException
     * @throws \Exception
     */
    public function repayment($scheduleId, $amount): void
    {
        $schedule = $this->scheduledPaymentRepo->getById($scheduleId);
        if($schedule->status != ScheduledPayment::SCHEDULED_PAYMENT_STATUS_APPROVE) {
            throw new \Exception('Scheduled repayment must be approve', 400);
        }

        if($schedule->amount > $amount) {
            throw new \Exception('Amount greater or equal to the scheduled repayment', 400);
        }

        try {
            DB::beginTransaction();
            $schedule = $this->scheduledPaymentRepo->update([
                'amount_paid' => $amount,
                'status' => ScheduledPayment::SCHEDULED_PAYMENT_STATUS_PAID
            ], $scheduleId);

            $schedulesPaidQty = $this->scheduledPaymentRepo->skipCache()
                ->scopeQuery(function($query) use ($schedule) {
                    return $query->where('loan_id', $schedule->loan_id)
                        ->where('status', ScheduledPayment::SCHEDULED_PAYMENT_STATUS_APPROVE);
                })->count();

            if($schedulesPaidQty == 0) {
                $this->loanRepo->update(['status' => Loan::LOAN_STATUS_PAID], $schedule->loan_id);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}