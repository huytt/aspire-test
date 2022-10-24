<?php

namespace Huytt\User\Models;

use Huytt\User\Contracts\User as UserContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends \App\Models\User implements JWTSubject, UserContract
{
    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
