<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\CountryTax;
use PHPUnit\Framework\TestCase;

class CountryTaxTest extends TestCase
{
    /** @test */
    public function it_should_set_and_get_correct_values()
    {
        //Given model
        $model = new CountryTax();

        //When assign values
        $model
            ->setCountry('Germany')
            ->setTax(12)
            ->setTaxNumFormat('GR\d{9}')
        ;

        //Then check we get correct values back
        self::assertEquals('Germany', $model->getCountry());
        self::assertEquals(12, $model->getTax());
        self::assertEquals('GR\d{9}', $model->getTaxNumFormat());
    }
}