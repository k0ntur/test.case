<?php

declare(strict_types=1);

namespace App\Exception;

class NotFoundTaxException extends \Exception
{
    protected $message = 'CountryTax for number `%1$s` not found';

    public function __construct(string $taxNumber, int $code = 0, ?\Throwable $previous = null)
    {
        $message = sprintf($this->message, $taxNumber);
        parent::__construct($message, $code, $previous);
    }
}