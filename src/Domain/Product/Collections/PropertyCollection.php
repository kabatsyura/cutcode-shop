<?php

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

final class PropertyCollection extends Collection
{
    public function keyValues()
    {
        return $this->mapWithKeys(fn ($prop) => [$prop->title => $prop->pivot->value]);
    }
}
