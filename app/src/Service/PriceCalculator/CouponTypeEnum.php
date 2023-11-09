<?php

declare(strict_types=1);

namespace App\Service\PriceCalculator;

enum CouponTypeEnum: string
{
    case FIXED = 'fixed';
    case PERCENT = 'percent';
}
