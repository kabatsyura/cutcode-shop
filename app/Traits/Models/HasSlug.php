<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        self::creating(function (Model $model) {
            $model->slug = $model->slug ?? str($model->{self::slugFrom()})->slug();
        });
    }

    // NOTE: this code I  can change in the nested class
    // and use another attribute, for example 'name'
    public static function slugFrom(): string
    {
        return 'title';
    }
}
