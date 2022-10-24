<?php

namespace Huytt\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Huytt\User\Http\Requests\RegisterRequest;
use Huytt\Core\Http\Transformers\BaseCoreCollection;
use Huytt\Core\Repository\Criteria\RequestCriteria;
use Huytt\User\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(
        UserRepository $repository,
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

        //Request is valid, create new user
        $user = $this->repository->create(array_merge($data, ['password' => bcrypt($data['password'])]));

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_CREATED);
    }
}
