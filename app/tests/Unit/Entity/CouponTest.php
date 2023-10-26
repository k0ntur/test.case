<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Coupon;
use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
    /** @test */
    public function it_should_set_and_get_correct_values(): void
    {
        //Given model
        $model = new Coupon();

        //When assign values
        $model
            ->setCode('promo')
            ->setDiscount(50);


        //Then check we get correct values back
        self::assertEquals('promo', $model->getCode());
        self::assertEquals(50, $model->getDiscount());
    }
}