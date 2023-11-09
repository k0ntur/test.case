<?php

declare(strict_types=1);

namespace App\Service\Purchase;

use App\Entity\Purchase;
use App\Exception\NotFoundCouponException;
use App\Exception\NotFoundProductException;
use App\Exception\NotFoundTaxException;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PriceCalculator\PriceCalculatorServiceInterface;
use App\Service\Purchase\Factory\PaymentProcessorFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class PurchaseService implements PurchaseServiceInterface
{
    public function __construct(
        private ServiceLocator $locator,
        private PriceCalculatorServiceInterface  $priceCalculatorService,
        private CountryTaxRepository $countryTaxRepository,
        private CouponRepository $couponRepository,
        private ProductRepository $productRepository,
        private EntityManagerInterface $em
    )
    {
    }

    public function purchase(int $productId, string $taxNumber, PaymentProcessorEnum $paymentProcessor, string $couponCode = ''):bool
    {
        $product = $this->productRepository->find($productId);

        if (null == $product){
            throw new NotFoundProductException($productId);
        }

        $tax = $this->countryTaxRepository->findOneByFormat($taxNumber);
        if (null == $tax){
            throw new NotFoundTaxException($taxNumber);
        }

        $sum = $this->priceCalculatorService->calculate($productId, $taxNumber, $couponCode);

        $paymentProcessorInst = $this->locator->get($paymentProcessor->value);

        $purchase = new Purchase();
        $this->em->persist($purchase);
        $purchase
            ->setProduct($product)
            ->setTaxNumber($taxNumber)
            ->setTaxRate($tax->getTax())
            ->setSum($sum)
            ->setPaymentStatus(PaymentStatusEnum::Pending)
            ->setPaymentProcessor($paymentProcessor);

        if (!empty($couponCode)) {
            $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);
            if (null == $coupon) {
                throw new NotFoundCouponException($couponCode);
            }

            $purchase
                ->setCouponCode($couponCode)
                ->setCouponDiscount($coupon->getDiscount())
            ;
        }

        try {
            $paymentProcessorInst->process($sum);
            $purchase->setPaymentStatus(PaymentStatusEnum::Payed);
        } catch (\Throwable $e) {
            $purchase->setPaymentStatus(PaymentStatusEnum::Error);
            throw $e;
        } finally {
            $this->em->flush();
        }

        return true;
    }
}