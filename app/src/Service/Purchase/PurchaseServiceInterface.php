<?php

declare(strict_types=1);

namespace App\Service\Purchase;

interface PurchaseServiceInterface
{
    public function purchase(int $productId, string $taxNumber, PaymentProcessorEnum $paymentProcessor, string $couponCode = ''):bool;
}