<?php

namespace Huytt\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Huytt\Core\Events\RepositoryEntityTouch;
use Huytt\Core\Listeners\CleanCacheRepository;
use Huytt\Core\Listeners\TouchCleanCacheRepository;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RepositoryEntityTouch::class => [
            TouchCleanCacheRepository::class
        ],
        'Prettus\Repository\Events\RepositoryEntityCreated' => [
            CleanCacheRepository::class
        ],
        'Prettus\Repository\Events\RepositoryEntityUpdated' => [
            CleanCacheRepository::class
        ],
        'Prettus\Repository\Events\RepositoryEntityDeleted' => [
            CleanCacheRepository::class
        ]
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
