<?php

declare(strict_types=1);

namespace App\Service\Purchase\Factory;

use App\Service\Purchase\PaymentProcessor\PaymentProcessorInterface;
use App\Service\Purchase\PaymentProcessorEnum;

interface PaymentProcessorFactoryInterface
{
    public function create(PaymentProcessorEnum $paymentProcessor):PaymentProcessorInterface;
}