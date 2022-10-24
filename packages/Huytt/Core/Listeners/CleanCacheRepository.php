<?php

namespace Huytt\Core\Listeners;

use Illuminate\Support\Facades\Log;
use Huytt\Core\Events\RepositoryEntityTouch;
use Huytt\Core\Helpers\CacheKeys;
use Prettus\Repository\Events\RepositoryEventBase;


class CleanCacheRepository extends \Prettus\Repository\Listeners\CleanCacheRepository
{
    /**
     * @param RepositoryEventBase $event
     */
    public function handle(RepositoryEventBase $event)
    {
        try {
            $cleanEnabled = config("repository.cache.clean.enabled", true);

            if ($cleanEnabled) {
                $this->repository = $event->getRepository();
                $this->model = $event->getModel();
                $this->action = $event->getAction();

                if (config("repository.cache.clean.on.{$this->action}", true)) {
                    $cacheKeys = CacheKeys::getKeys(get_class($this->repository));

                    if (is_array($cacheKeys)) {
                        foreach ($cacheKeys as $key) {
                            $this->cache->forget($key);
                        }
                    }

                    // clear touch repo
//                    $touchRepositoryClass = method_exists($this->repository, 'getTouchRepositoryClass') ? $this->repository->getTouchRepositoryClass() : [];
//                    event(new RepositoryEntityTouch($touchRepositoryClass));
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
