<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;

final class CheckOrderQuantities implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        foreach(cart()->items() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new OrderProcessException('Не достаточно товара на складе');
            }
        }

        return $next($order);
    }
}
