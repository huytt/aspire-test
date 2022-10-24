<?php

namespace Huytt\Auth\Providers;

use Huytt\Admin\Models\Admin;
use Huytt\Core\Providers\CoreModuleServiceProvider;
use Huytt\User\Models\User;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
    ];

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub

        $this->app->register(AuthServiceProvider::class);
    }
}
