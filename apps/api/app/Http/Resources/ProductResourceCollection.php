<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResourceCollection extends ResourceCollection
{
    /**
     * @var array
     */
    protected $withoutFields = [];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->processCollection($request);
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }
    /**
     * Send fields to hide to UsersResource while processing the collection.
     *
     * @param $request
     * @return array
     */
    protected function processCollection($request)
    {
        return $this->collection->map(function (ProductResource $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }
}
