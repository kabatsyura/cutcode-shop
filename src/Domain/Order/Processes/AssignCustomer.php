<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;

final class AssignCustomer implements OrderProcessContract
{
    public function __construct(protected array $customer)
    {

    }
    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create($this->customer);

        return $next($order);
    }
}
