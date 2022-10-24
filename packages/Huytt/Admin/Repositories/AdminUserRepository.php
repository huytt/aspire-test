<?php

namespace Huytt\Admin\Repositories;


use Huytt\Admin\Contracts\Admin;
use Huytt\Core\Eloquent\Repository;

class AdminUserRepository extends Repository
{
    public function model(): string
    {
        return Admin::class;
    }
}
