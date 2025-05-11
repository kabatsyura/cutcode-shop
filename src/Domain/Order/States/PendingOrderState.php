<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

final class PendingOrderState extends OrderState
{
    protected array $allowedTranstions = [
        PaidOrderState::class,
        CanceledOrderState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function humanValue(): string
    {
        return 'В обработке';
    }

    public function value(): string
    {
        return OrderStatuses::PENDING->value;
    }
}
