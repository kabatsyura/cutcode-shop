<?php

namespace Domain\Order\Providers;

use Domain\Order\Payment\Gateways\YooKassa;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

    }

    public function register(): void
    {
        // PaymentSystem::provider(function () {
        //     return new YooKassa(config('payment.providers.yookassa'));
        // });

        // PaymentSystem::onCreating(function (PaymentData $paymentData) {
        //     return $paymentData;
        // });

        // PaymentSystem::onSuccess(function (PaymentData $paymentData) {
        // });

        // PaymentSystem::onError(function (string $message, PaymentData $paymentData) {
        // });
    }
}
