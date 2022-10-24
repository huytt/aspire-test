<?php

namespace Huytt\Admin\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class AdminServiceProvider extends BaseModuleServiceProvider
{
    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
