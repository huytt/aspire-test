<?php


namespace Huytt\Core\Providers;


use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Huytt\Core\Core;
use Huytt\Core\Facades\Core as CoreFacade;
use Huytt\Core\Services\FirebaseService;
use Huytt\Core\Services\FirebaseServiceInterface;

class CoreServiceProvider extends ServiceProvider
{
    public function boot() {
        include __DIR__ . '/../helpers.php';

//        dd(env('APP_DEBUG'));
        // Debug sql query
        if(env('APP_DEBUG', true)){
            DB::listen(function($query) {
                Log::debug(
                    core()->getSql($query->sql, $query->bindings)
                );
            });
        }
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
        $this->registerFacades();
        $this->app->bind(FirebaseServiceInterface::class, function ($app) {
            return new FirebaseService();
        });
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('core', CoreFacade::class);

        $this->app->singleton('core', function () {
            return new core();
        });

        $this->app->bind('core', Core::class);
    }
}