<?php

namespace Huytt\Core\Generators;

use Illuminate\Database\Eloquent\Model;

class Sequencer
{
    /**
     * @inheritDoc
     */
    public static function generate(Model $model, $orderField = 'id', $default = null, $length = 0, \Closure $closure = null, $prefix = null, $suffix = null): string
    {
        $last = $closure ? $closure():  $model::query()->orderBy($orderField, 'desc')->limit(1)->first();
        $lastId = $last ? $last->{$orderField} : $default;

        if ($length && ($prefix || $suffix)) {
            $lenPre = strlen($prefix);
            $lenSuf = strlen($suffix);
            $lenConcat = $length - ($lenPre + $lenSuf + strlen($lastId + 1));
            if($lenConcat >= 0) {
                return ($prefix) . sprintf("%0{$lenConcat }d",
                        0) . ($lastId + 1) . ($suffix);
            }
        }

        return $lastId + 1;
    }

    /**
     * @inheritDoc
     */
    public static function generateBaseCount(Model $model, $lengthPad = 0, $stringPad = "0", $prefix = null, $suffix = null): string
    {
        $count = $model::query()->count();

        return ($prefix).str_pad($count + 1, $lengthPad, $stringPad, STR_PAD_LEFT).($suffix);
    }

}
