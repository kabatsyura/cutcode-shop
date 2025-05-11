<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use App\Events\OrderCreated;
use Domain\Order\Models\Order;
use DomainException;
use Illuminate\Pipeline\Pipeline;
use Support\Transaction;

final class OrderProcess
{
    protected array $processes = [];

    public function __construct(protected Order $order) {}

    public function processes(array $processes): self
    {
        $this->processes = $processes;

        return $this;
    }

    public function run(): Order
    {
        return Transaction::run(fn () => app(Pipeline::class)
            ->send($this->order)
            ->through($this->processes)
            ->thenReturn(),
            function (Order $order) {
                flash()->info('Good # '. $order->id);

                event(new OrderCreated($order));
            },
            function (\Throwable $e) {
                throw new DomainException($e->getMessage());
                // throw new DomainException('Что-то пошло не так. Обратитесь в тех. поддержку');
            }
        );
    }
}
