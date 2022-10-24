<?php

namespace Huytt\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use Huytt\Core\Http\Transformers\BaseCoreCollection;
use Huytt\Core\Repository\Criteria\RequestCriteria;
use Huytt\Loan\Http\Requests\LoanCreateRequest;
use Huytt\Loan\Repositories\LoanRepository;
use Huytt\Loan\Services\LoanServices;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\Response;

class LoanController extends Controller
{
    /**
     * @var LoanServices
     */
    protected $loanService;


    public function __construct(
        LoanServices $loanService,
    ) {
        $this->loanService = $loanService;
    }

    /**
     * @param LoanCreateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(LoanCreateRequest $request): JsonResponse
    {
        try {
            $loan = $this->loanService->store($request);
            return core()->success(Response::HTTP_CREATED, [
                'id' => $loan->id
            ], 'Loan created successfully');
        } catch (\Exception $e) {
            dd($e->getCode(), $e->getMessage());
            return core()->error($e->getCode(), $e->getCode(), $e->getMessage());
        }

    }

//    /**
//     * Display a listing of the resource.
//     *
//     * @return JsonResponse
//     * @throws RepositoryException
//     */
//    public function index(): JsonResponse
//    {
//        $params = request()->input();
//        $perPage = isset($params['limit']) && ! empty($params['limit']) ? $params['limit'] : 50;
//        $this->repository->pushCriteria(app(RequestCriteria::class));
//
//        return response()->json(new BaseCoreCollection($this->repository->skipCache()->paginate($perPage)));
//    }
}
