<?php

declare(strict_types=1);

namespace App\Service\Purchase\Factory;

use App\Service\Purchase\PaymentProcessor\PaymentProcessorInterface;
use App\Service\Purchase\PaymentProcessor\PaypalPaymentProcessor;
use App\Service\Purchase\PaymentProcessor\StripePaymentProcessor;
use App\Service\Purchase\PaymentProcessorEnum;

class PaymentProcessorFactory implements PaymentProcessorFactoryInterface
{
    public function create(PaymentProcessorEnum $paymentProcessor):PaymentProcessorInterface
    {
        return match ($paymentProcessor){
            PaymentProcessorEnum::Paypal => new PaypalPaymentProcessor(),
            PaymentProcessorEnum::Stripe => new StripePaymentProcessor(),
            default => throw new InvalidArgumentException($paymentProcessor->value)
        };
    }
}