<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * @param mixed $resource
     * @return mixed
     */
    public static function collection($resource)
    {
        return tap(new ProductResourceCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    /**
     * @var array
     */
    protected $withoutFields = [];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'title' => $this->title,
            'url' => $this->url,
            'abstract' => $this->abstract,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $this->image_url,
            'stock' => $this->stock
        ]);
    }

    /**
     * Set the keys that are supposed to be filtered out.
     *
     * @param array $fields
     * @return $this
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }
    /**
     * Remove the filtered keys.
     *
     * @param $array
     * @return array
     */
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
}
