<?php
namespace Huytt\Loan\Services;

use Huytt\Core\Repository\Criteria\RequestCriteria;
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
}