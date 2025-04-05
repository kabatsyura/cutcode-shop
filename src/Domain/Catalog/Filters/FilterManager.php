<?php

namespace Domain\Catalog\Filters;

final class FilterManager
{
    public function __construct(protected array $items = []) {}

    public function registersFilters(array $items): void
    {
        $this->items = $items;
    }

    public function items(): array
    {
        return $this->items;
    }
}
