<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProductJsonPropertiesJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $properties = $this->product->properties->mapWithKeys(fn ($prop) => [$prop->title => $prop->pivot->value]);
        $this->product ->updateQuietly(['json_properties' => $properties]);
    }

    public function uniqueId()
    {
        return $this->product->getKey();
    }
}
