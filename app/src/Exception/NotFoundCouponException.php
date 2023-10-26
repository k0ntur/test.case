<?php

declare(strict_types=1);

namespace App\Exception;

class NotFoundCouponException extends \Exception
{
    protected $message = 'Coupon with code `%1$s` not found';

    public function __construct(string $couponCode, int $code = 0, ?\Throwable $previous = null)
    {
        $message = sprintf($this->message, $couponCode);
        parent::__construct($message, $code, $previous);
    }
}