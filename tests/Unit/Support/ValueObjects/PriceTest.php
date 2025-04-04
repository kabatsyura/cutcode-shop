<?php

namespace Tests\Unit\Support\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Support\ValueObjects\Price;
use Tests\TestCase;

final class PriceTest extends TestCase
{
    #[Test]
    public function testPrice(): void
    {
        $price = Price::make(100000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(1000, $price->value());
        $this->assertEquals(100000, $price->raw());
        $this->assertEquals('RUB', $price->currency());
        $this->assertEquals('₽', $price->symbol());
        $this->assertEquals('1 000,00 ₽', $price);

        $this->expectException(InvalidArgumentException::class);

        Price::make(-1000);
        Price::make(100, 'CNY');
    }
}
