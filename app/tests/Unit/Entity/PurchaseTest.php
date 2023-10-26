<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Product;
use App\Entity\Purchase;
use App\Service\Purchase\PaymentProcessorEnum;
use App\Service\Purchase\PaymentStatusEnum;
use PHPUnit\Framework\TestCase;

class PurchaseTest extends TestCase
{
    /** @test */
    public function it_should_set_and_get_correct_values(): void
    {
        //Given model
        $model = new Purchase();
        $product = new Product();

        //When assign values
        $model
            ->setCouponCode('promo')
            ->setCouponDiscount(20)
            ->setPaymentProcessor(PaymentProcessorEnum::Paypal)
            ->setPaymentStatus(PaymentStatusEnum::Payed)
            ->setSum(500)
            ->setProduct($product)
            ->setTaxNumber('GR123456789')
            ->setTaxRate(18)
        ;


        //Then check we get correct values back
        self::assertEquals('promo', $model->getCouponCode());
        self::assertEquals(20, $model->getCouponDiscount());
        self::assertSame(PaymentProcessorEnum::Paypal, $model->getPaymentProcessor());
        self::assertSame(PaymentStatusEnum::Payed, $model->getPaymentStatus());
        self::assertEquals(500, $model->getSum());
        self::assertSame($product, $model->getProduct());
        self::assertEquals('GR123456789', $model->getTaxNumber());
        self::assertEquals(18, $model->getTaxRate());

    }
}