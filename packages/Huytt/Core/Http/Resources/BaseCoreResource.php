<?php

namespace Huytt\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseCoreResource extends JsonResource
{
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $new = [];
        foreach ($parent as $key => $value)
        {
            $new[lcfirst($key)] = $value;
        }
        return $new;
    }
}

