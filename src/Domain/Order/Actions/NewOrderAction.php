<?php

declare(strict_types=1);

namespace Domain\Order\Actions;

use App\Http\Requests\OrderFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\Models\Order;

final class NewOrderAction
{
    public function __invoke(OrderFormRequest $request): Order
    {
        $registerAction = app(RegisterNewUserContract::class);
        $customer = $request->validated('customer');
        $isNeedToCreateAccount = $request->validated('create_account');

        if($isNeedToCreateAccount ) {
            $registerAction(NewUserDTO::make(
                $customer['first_name'] . ' ' . $customer['last_name'],
                $customer['email'],
                $request->validated('password')
            ));
        }

        return Order::query()->create([
            'payment_method_id' => $request->validated('payment_method_id'),
            'delivery_type_id' => $request->validated('delivery_type_id')
        ]);
    }
}
