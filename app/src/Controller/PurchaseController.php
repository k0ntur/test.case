<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\PurchaseRequest;
use App\Service\Purchase\PaymentProcessorEnum;
use App\Service\Purchase\PurchaseServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/purchase', name: 'purchase', methods: [Request::METHOD_POST])]
class PurchaseController extends AbstractController
{
    public function __construct(
        private PurchaseServiceInterface $purchaseService
    )
    {
    }

    public function __invoke(PurchaseRequest $request): Response
    {
        try {
            $this->purchaseService->purchase(
                $request->productId,
                $request->taxNumber,
                PaymentProcessorEnum::from($request->paymentProcessor),
                $request->couponCode
            );
        } catch(\Exception $e){
            return $this->json(
                ['errors' => [$e->getMessage()]],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            ['ok' => true]
        );
    }
}