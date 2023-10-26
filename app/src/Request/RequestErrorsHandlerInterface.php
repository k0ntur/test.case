<?php

declare(strict_types=1);

namespace App\Request;

interface RequestErrorsHandlerInterface
{
    public function handle(array $errors):void;
}