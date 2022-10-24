<?php

return [
    'modules' => [
        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */
        Huytt\Core\Providers\ModuleServiceProvider::class,
        Huytt\Auth\Providers\ModuleServiceProvider::class,
        Huytt\User\Providers\ModuleServiceProvider::class,
        Huytt\Admin\Providers\ModuleServiceProvider::class,
    ],
    'register_route_models' => true
];
