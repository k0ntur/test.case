<?php

declare(strict_types=1);

namespace App\Exception;

class NotFoundProductException extends \Exception
{

    protected $message = 'Product with ID `%1$d` not found';

    public function __construct(int $productId, int $code = 0, ?\Throwable $previous = null)
    {
        $message = sprintf($this->message, $productId);
        parent::__construct($message, $code, $previous);
    }
}