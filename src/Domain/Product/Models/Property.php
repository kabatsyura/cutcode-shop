<?php

namespace Domain\Product\Models;

use Domain\Product\Collections\PropertyCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function newCollection(array $models = [])
    {
        return new PropertyCollection($models);
    }
}
