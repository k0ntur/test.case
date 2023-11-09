<?php

declare(strict_types=1);

namespace App\Service\Purchase\PaymentProcessor;

use App\Service\Purchase\PaymentProcessorEnum;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor as StripeProcessor;

class StripePaymentProcessor implements PaymentProcessorInterface
{
    private StripeProcessor $processor;

    public function __construct()
    {
        $this->processor = new StripeProcessor();
    }

    public function process(int $sum): bool
    {
        if ($this->processor->processPayment($this->convert($sum))) {
            return true;
        }

        throw new PaymentServiceError(sprintf("Cant process Stripe payment right now. Payment Sum: %1$.2f", $this->convert($sum)));
    }

    //we must divide $sum by 100 since strype service accepts euro units but we keep prices in cents
    private function convert(int $sum):float
    {
        return $sum / 100;
    }

    public static function getServiceName(): string
    {
        return PaymentProcessorEnum::Stripe->value;
    }
}