<?php

namespace App\Events;

use App\Product;
use Illuminate\Queue\SerializesModels;

class ProductSave
{
    use SerializesModels;

    public $product;

    /**
     * Create a new event instance.
     *
     * @param \App\Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}