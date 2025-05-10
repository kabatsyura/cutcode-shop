<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

final class CanceledOrderState extends OrderState
{
    protected array $allowedTranstions = [];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function humanValue(): string
    {
        return 'Отменен';
    }

    public function value(): string
    {
        return OrderStatuses::CANCELED->value;
    }
}
