<?php

declare(strict_types=1);

namespace App\Service\Purchase\PaymentProcessor;

use App\Service\Purchase\PaymentProcessorEnum;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor as PaypalProcessor;

class PaypalPaymentProcessor  implements PaymentProcessorInterface
{
    private PaypalProcessor $processor;

    public function __construct()
    {
        $this->processor = new PaypalProcessor();
    }

    public function process(int $sum): bool
    {
        try {
            $this->processor->pay($sum);
        } catch (\Exception $e){
            throw new PaymentServiceError(sprintf('Cant process Paypal payment right now. Payment sum: %1$d. Additional info: %2$s', $sum, $e->getMessage()));
        }
        return true;
    }

    public static function getServiceName(): string
    {
        return PaymentProcessorEnum::Paypal->value;
    }
}