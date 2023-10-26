<?php

declare(strict_types=1);

namespace App\Service\Purchase;

enum PaymentProcessorEnum: string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';

    public static function getProcessors():array
    {
        $processors = [];
        foreach (self::cases() as $case){
            $processors[] = $case->value;
        }

        return $processors;
    }
}
