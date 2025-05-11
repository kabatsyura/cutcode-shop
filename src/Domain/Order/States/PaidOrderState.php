<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Enums\OrderStatuses;

final class PaidOrderState extends OrderState
{
    protected array $allowedTranstions = [
        CanceledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function humanValue(): string
    {
        return 'Оплачен';
    }

    public function value(): string
    {
        return OrderStatuses::PAID->value;
    }
}
