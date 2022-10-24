<?php

namespace Huytt\Admin\Models;

use Huytt\Admin\Contracts\Admin as AdminContract;
use Huytt\User\Models\User;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends User implements JWTSubject, AdminContract
{
    protected $table = 'admins';
    protected $guarded = 'admin-api';
}
