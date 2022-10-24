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
            return core()->error($e->getCode(), $e->getCode(), $e->getMessage());
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function meList(): JsonResponse
    {
        return core()->success(Response::HTTP_OK, new BaseCoreCollection($this->loanService->meList()));
    }
}
