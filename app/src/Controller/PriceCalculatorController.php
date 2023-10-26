<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\PriceCalculateRequest;
use App\Service\PriceCalculator\PriceCalculatorServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calculate-price', name: 'app-calculate-price', methods: [Request::METHOD_POST])]
class PriceCalculatorController extends AbstractController
{
    public function __construct(
        private PriceCalculatorServiceInterface $priceCalculator
    )
    {
    }

    public function __invoke(PriceCalculateRequest $request): Response
    {
        try {
            $summ = $this->priceCalculator->calculate($request->productId, $request->taxNumber, $request->couponCode);
        } catch (\Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['ok' => true, 'sum' => $summ]);
    }
}