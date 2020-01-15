<?php

namespace App\Listeners;

use App\Events\ProductSave as ProductSaveEvent;

class ProductSave
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductSaveEvent $event
     * @return mixed
     */
    public function handle(ProductSaveEvent $event)
    {
        app('log')->info($event->product);
    }
}