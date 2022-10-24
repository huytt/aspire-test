<?php

namespace Huytt\Auth\Http\Controllers;

use Huytt\Auth\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends AuthController
{
//    /** @var AdminUserRepository */
//    protected $repository;
//
//    public function __construct(AdminUserRepository $repository)
//    {
//        $this->repository = $repository;
//    }

    public function authenticate(AuthRequest $request): \Illuminate\Http\JsonResponse|array
    {
        Auth::shouldUse('admin-api');
        return parent::authenticate($request);
    }

//    /**
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function register(Request $request): \Illuminate\Http\JsonResponse
//    {
//        //Validate data
//        $data = $request->only('name', 'email', 'password');
//        $validator = Validator::make($data, [
//            'name' => 'required|string',
//            'email' => 'required|email|unique:admins',
//            'password' => 'required|string|min:6|max:50'
//        ]);
//
//        //Send failed response if request is not valid
//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->messages()], 200);
//        }
//
//        //Request is valid, create new user
//        $user = Admin::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => bcrypt($request->password)
//        ]);
//
//        //User created, return success response
//        return response()->json([
//            'success' => true,
//            'message' => 'User created successfully',
//            'data' => $user
//        ], Response::HTTP_OK);
//    }
}
