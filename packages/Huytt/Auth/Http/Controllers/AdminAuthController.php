<?php

namespace Huytt\Auth\Http\Controllers;

use Huytt\Auth\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends AuthController
{
    public function authenticate(AuthRequest $request): \Illuminate\Http\JsonResponse|array
    {
        Auth::shouldUse('admin-api');
        return parent::authenticate($request);
    }
}
