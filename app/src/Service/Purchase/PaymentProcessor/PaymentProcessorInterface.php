<?php

declare(strict_types=1);

namespace App\Service\Purchase\PaymentProcessor;

interface PaymentProcessorInterface
{
    public function process(int $sum): bool;
}