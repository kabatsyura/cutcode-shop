<?php

declare(strict_types=1);

namespace Domain\Order\States;

use App\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTranstions = [];

    public function __construct(protected Order $order) {}

    abstract public function canBeChanged(): bool;

    abstract public function humanValue(): string;

    abstract public function value(): string;

    public function transitionTo(OrderState $orderState): void
    {
        if (! $this->canBeChanged()) {
            throw new InvalidArgumentException("Status can't be changed!");
        }

        if (! in_array(get_class($orderState), $this->allowedTranstions)) {
            throw new InvalidArgumentException(
                "No transition for {$this->order->status->value()} to {$orderState->value()}"
            );
        }

        $this->order->updateQuietly([
            'status' => $orderState->value()
        ]);

        event(new OrderStatusChanged(
            $this->order,
            $this->order->status,
            $orderState
        ));
    }
}
