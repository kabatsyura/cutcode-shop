<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ThumbnailControllerTest extends TestCase
{
    #[Test]
    public function itGeneratedSucced(): void
    {
        $size = '675x675';
        $method = 'resize';
        $storage = Storage::disk('images');

        config()->set('thumbnail', ['allowed_sizes' => [$size]]);
        $product = ProductFactory::new()->create();

        $response = $this->get($product->makeThumbnail($size, $method));

        $response->assertOk();
        $storage->assertExists(
            "/products/$method/$size/" . File::basename($product->thumbnail)
        );
    }
}
