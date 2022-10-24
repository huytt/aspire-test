<?php

namespace Huytt\User\Repositories;

use Huytt\Core\Eloquent\Repository;
use Huytt\User\Contracts\User;

class UserRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }
}
