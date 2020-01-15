<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UuidKey;
use App\Events\ProductSave;

class Product extends Authenticatable
{
    use UuidKey;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku', 'title', 'url', 'abstract', 'description', 'price', 'image_url', 'stock'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'abstract' => 'boolean'
    ];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'abstract' => false,
        'stock' => 0
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => ProductSave::class,
    ];
}
