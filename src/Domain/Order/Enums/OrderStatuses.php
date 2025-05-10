<?php

declare(strict_types=1);

namespace Domain\Order\Enums;

use Domain\Order\Models\Order;
use Domain\Order\States\CanceledOrderState;
use Domain\Order\States\NewOrderState;
use Domain\Order\States\OrderState;
use Domain\Order\States\PaidOrderState;
use Domain\Order\States\PendingOrderState;

enum OrderStatuses: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELED = 'canceled';

    public function createState(Order $order): OrderState
    {
        return match($this) {
            OrderStatuses::NEW => new NewOrderState($order),
            OrderStatuses::PENDING => new PendingOrderState($order),
            OrderStatuses::PAID => new PaidOrderState($order),
            OrderStatuses::CANCELED => new CanceledOrderState($order)
        };
    }
}
