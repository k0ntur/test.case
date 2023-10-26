<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\PurchaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/purchase', name: 'purchase', methods: [Request::METHOD_POST])]
class PurchaseController extends AbstractController
{
    public function __construct()
    {
    }

    public function __invoke(PurchaseRequest $request): Response
    {

        return new JsonResponse(['ok' => true]);
    }
}