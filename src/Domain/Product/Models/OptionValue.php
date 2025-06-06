<?php

namespace Domain\Product\Models;

use Domain\Product\Collections\OptionValueCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    /** @use HasFactory<\Database\Factories\OptionValueFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'option_id'
    ];

    public function newCollection(array $models = [])
    {
        return new OptionValueCollection($models);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
