<?php

declare(strict_types=1);

namespace App\Service\PriceCalculator;

interface PriceCalculatorServiceInterface
{
    public function calculate(int $productId, string $taxNum, string $couponCode = null):int;
}