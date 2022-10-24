<?php

namespace Huytt\Core\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheKeys extends \Prettus\Repository\Helpers\CacheKeys
{
    protected static $repositoryCacheKeys = "repository-cache-keys";

    /**
     * @param $group
     * @param $key
     *
     * @return void
     */
    public static function putKey($group, $key)
    {
        self::loadKeys();

        self::$keys[$group] = self::getKeys($group);

//        echo $key."\n";

        if (!in_array($key, self::$keys[$group])) {
            self::$keys[$group][] = $key;
            Cache::forever(self::$repositoryCacheKeys, self::$keys);
        }
//        echo json_encode(self::$keys[$group])."\n";

//        self::storeKeys();
//        return true;
    }

    /**
     * @return array|mixed
     */
    public static function loadKeys()
    {
        self::$keys = Cache::get(self::$repositoryCacheKeys);
        return self::$keys;
    }

    /**
     * @return int
     */
    public static function storeKeys()
    {
        self::$keys = Cache::rememberForever(self::$repositoryCacheKeys, function (){
            return is_null(self::$keys) ? [] : self::$keys;
        });

        return true;
    }

    /**
     * @param $group
     *
     * @return array|mixed
     */
    public static function getKeys($group)
    {
        self::loadKeys();
        self::$keys[$group] = isset(self::$keys[$group]) ? self::$keys[$group] : [];

        return self::$keys[$group];
    }
}
