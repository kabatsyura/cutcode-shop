<?php

namespace Domain\Catalog\Facade;

use Domain\Catalog\Sorters\Sorter as SortersSorter;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Builder run(Builder $query)
 * @see SortersSorter
 */
final class Sorter extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return SortersSorter::class;
    }
}
