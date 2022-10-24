<?php

namespace Huytt\Core\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $key  =  $model->getKeyName();
                $model->{$key} = (string)Str::uuid();
            } catch (\Exception $exception) {
                abort(500, $exception->getMessage());
            }
        });
    }

    /**
     * Override the getIncrementing() function to return false to tell
     * Laravel that the identifier does not auto increment (it's a string).
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }


    /**
     * Tell laravel that the key type is a string, not an integer.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'uuid';
    }
}
