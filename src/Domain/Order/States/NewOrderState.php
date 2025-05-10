<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

final class NewOrderState extends OrderState
{
    protected array $allowedTranstions = [
        PendingOrderState::class,
        CanceledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function humanValue(): string
    {
        return 'Новый заказ';
    }

    public function value(): string
    {
        return OrderStatuses::NEW->value;
    }
}
