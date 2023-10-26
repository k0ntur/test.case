<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

class RequestErrorsSendJson implements RequestErrorsHandlerInterface
{
    public function handle(array $errors): void
    {
        $response = new JsonResponse(['errors' => $errors], 400);
        $response->send();
        exit;
    }
}