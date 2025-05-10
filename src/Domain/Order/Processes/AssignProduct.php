<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;

final class AssignProduct implements OrderProcessContract
{
    public function handle(Order $order, $next)
    {
        $order->orderItems()
            ->createMany(
                cart()->items()->map(fn ($item) => [
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ])->toArray()
            );

        return $next($order);
    }
}
