<?php

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

final class OptionValueCollection extends Collection
{
    public function keyValues()
    {
        return $this->mapToGroups(fn ($item) => [$item->option->title => $item]);
    }
}
