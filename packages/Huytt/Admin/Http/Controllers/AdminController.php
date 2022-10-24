<?php

namespace Huytt\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Huytt\Core\Http\Transformers\BaseCoreCollection;
use Huytt\Core\Repository\Criteria\RequestCriteria;
use Huytt\Admin\Repositories\AdminUserRepository;
use Huytt\User\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @var AdminUserRepository
     */
    protected $repository;

    /**
     * AdminController constructor.
     *
     * @param AdminUserRepository $repository
     */
    public function __construct(
        AdminUserRepository $repository,
    ){
        $this->repository = $repository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function index(): JsonResponse
    {
        $params = request()->input();
        $perPage = isset($params['limit']) && ! empty($params['limit']) ? $params['limit'] : 50;
        $this->repository->pushCriteria(app(RequestCriteria::class));

        return response()->json(new BaseCoreCollection($this->repository->skipCache()->paginate($perPage)));
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only('name', 'email', 'password');

        //Request is valid, create new Admin
        $Admin = $this->repository->create(array_merge($data, ['password' => bcrypt($data['password'])]));

        //Admin created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Admin User created successfully',
            'data' => $Admin
        ], Response::HTTP_CREATED);
    }
}
