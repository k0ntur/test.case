<?php

declare(strict_types=1);

namespace App\Service\PriceCalculator;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Exception\NotFoundCouponException;
use App\Exception\NotFoundProductException;
use App\Exception\NotFoundTaxException;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

class PriceCalculatorServiceService implements PriceCalculatorServiceInterface
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected CountryTaxRepository $countryTaxRepository,
        protected CouponRepository $couponRepository
    )
    {
    }

    public function calculate(int $productId, string $taxNum, string $couponCode = null): int
    {
        /** @var Product $product */
        $product = $this->productRepository->find($productId);
        if (null == $product) {
            throw new NotFoundProductException($productId);
        }
        $price = $product->getPrice();

        if (null != $couponCode) {
            /** @var Coupon $coupon */
            $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);
            if (null == $coupon) {
                throw new NotFoundCouponException($couponCode);
            }

            $price = match($coupon->getType()){
                CouponTypeEnum::PERCENT => $price - floor($price * $coupon->getDiscount() / 100),
                CouponTypeEnum::FIXED => max(0, $price - $coupon->getDiscount()),
                default => throw new \Exception('Not found Coupon Type')
            };

        }

        $tax = $this->countryTaxRepository->findOneByFormat($taxNum);
        if (null == $tax) {
            throw new NotFoundTaxException($taxNum);
        }
        $price += floor($price * $tax->getTax()/100);

        return (int)$price;
    }
}