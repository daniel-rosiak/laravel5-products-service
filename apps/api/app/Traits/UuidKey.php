<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait UuidKey
{

    /**
     * Boot function from laravel.
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::generate(4);
        });
    }
}