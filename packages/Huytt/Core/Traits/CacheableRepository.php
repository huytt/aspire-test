<?php

namespace Huytt\Core\Traits;

use Huytt\Core\Helpers\CacheKeys;

trait CacheableRepository
{
    use \Prettus\Repository\Traits\CacheableRepository;

    /**
     * Get Cache key for the method
     *
     * @param $method
     * @param $args
     *
     * @return string
     */
    public function getCacheKey($method, $args = null): string
    {

        $request = app('Illuminate\Http\Request');
        $args = serialize($args);
        $criteria = $this->serializeCriteria();
        $key = sprintf('%s@%s-%s', get_called_class(), $method, md5($args . $criteria . $request->fullUrl()));

        CacheKeys::putKey(get_called_class(), $key);

        return $key;

    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        if (!$this->allowedCache('findWhere') || $this->isSkippedCache()) {
            return parent::findWhere($where, $columns);
        }

        $key = $this->getCacheKey('findWhere', array_merge(func_get_args(), [
            'personalId' => auth()->user()->personalID ?? null
        ]));
        $time = $this->getCacheTime();
        $value = $this->getCacheRepository()->remember($key, $time, function () use ($where, $columns) {
            return parent::findWhere($where, $columns);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        if (!$this->allowedCache('findByField') || $this->isSkippedCache()) {
            return parent::findByField($field, $value, $columns);
        }

        $key = $this->getCacheKey('findByField', array_merge(func_get_args(), [
            'personalId' => auth()->user()->personalID ?? null
        ]));

        $time = $this->getCacheTime();
        $value = $this->getCacheRepository()->remember($key, $time, function () use ($field, $value, $columns) {
            return parent::findByField($field, $value, $columns);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }
}
