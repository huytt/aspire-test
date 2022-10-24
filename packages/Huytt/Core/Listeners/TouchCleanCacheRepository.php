<?php

namespace Huytt\Core\Listeners;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Log;
use Huytt\Core\Events\RepositoryEntityTouch;
use Huytt\Core\Helpers\CacheKeys;

class TouchCleanCacheRepository
{
    /**
     * @var CacheRepository
     */
    protected $cache = null;

    public function __construct()
    {
        $this->cache = app(config('repository.cache.repository', 'cache'));
    }

    /**
     * @param RepositoryEntityTouch $event
     */
    public function handle(RepositoryEntityTouch $event)
    {
        try {
            $cleanEnabled = config("repository.cache.clean.enabled", true);

            if ($cleanEnabled) {
                $touchRepositories = $event->getTouchRepositories();
                foreach ($touchRepositories as $repositoryClass) {
                    $cacheKeys = CacheKeys::getKeys($repositoryClass);

                    if (is_array($cacheKeys)) {
                        foreach ($cacheKeys as $key) {
                            $this->cache->forget($key);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
