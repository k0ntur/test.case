<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_should_set_and_get_correct_values(): void
    {
        //Given model
        $model = new Product();

        //When assign values
        $model
            ->setName('Iphone')
            ->setPrice(1000);


        //Then check we get correct values back
        self::assertEquals('Iphone', $model->getName());
        self::assertEquals(1000, $model->getPrice());
    }

}