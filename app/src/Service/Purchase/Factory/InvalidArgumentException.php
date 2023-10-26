<?php

declare(strict_types=1);

namespace App\Service\Purchase\Factory;

class InvalidArgumentException extends \Exception
{
    protected $message = 'Payment Processor for `%1$s` Not found';

    public function __construct(string $processor = "", int $code = 0, ?\Throwable $previous = null)
    {
        $message = sprintf($this->message, $processor);

        parent::__construct($message, $code, $previous);
    }
}