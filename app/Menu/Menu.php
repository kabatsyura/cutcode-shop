<?php

namespace App\Menu;

use Countable;
use Illuminate\Database\Eloquent\Collection;
use IteratorAggregate;
use Support\Traits\Makeable;
use Traversable;

final class Menu implements IteratorAggregate, Countable
{
    use Makeable;

    protected array $items = [];

    public function __construct(MenuItem ...$menuItem)
    {
        $this->items = $menuItem;
    }

    public function all(): Collection
    {
        return Collection::make($this->items);
    }

    // NOTE: when we return self - it's fluent interface pattern
    public function add(MenuItem $menuItem): self
    {
        $this->items[] = $menuItem;
        return $this;
    }

    public function addIf(bool|callable $condition, MenuItem $menuItem): self
    {
        if (is_callable($condition) ? $condition() : $condition) {
            $this->items[] = $menuItem;
        }
        return $this;
    }

    public function remove(MenuItem $menuItem): self
    {
        $this->items = $this->all()
            ->filter(fn (MenuItem $currMenuItem) => $currMenuItem !== $menuItem)
            ->toArray();

        return $this;
    }

    public function removeByLink(string $link): self
    {
        $this->items = $this->all()
            ->filter(fn (MenuItem $currMenuItem) => $currMenuItem->link() !== $link)
            ->toArray();

        return $this;
    }

    public function getIterator(): Traversable
    {
        return $this->all();
    }

    public function count(): int
    {
        return count($this->items);
    }
}
