<?php


namespace Huytt\Core\Http\Transformers;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Huytt\ProjectStructure\Http\Resources\HouseUnit;

class BaseCoreCollectionNoPaginate extends ResourceCollection
{
    protected function transformCollection(){
        return $this->collection;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items'=> $this->transformCollection(),
        ];
    }
}
