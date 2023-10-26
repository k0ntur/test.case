<?php

declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Entity\CountryTax;
use App\Repository\CountryTaxRepository;
use App\Tests\Integration\BaseKernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class CountryTaxRepositoryTest extends BaseKernelTestCase
{
    public function providerOfCountryCodes()
    {
        yield 'Germany country code' => ['DE123456789', 'Germany', 19];
        yield 'Italy country code' => ['IT12345678911', 'Italy', 22];
        yield 'France country code' => ['FRzM123456789', 'France', 20];
        yield 'Greece country code' => ['GR123456789', 'Greece', 24];
    }

    /**
     * @test
     * @dataProvider  providerOfCountryCodes
     */
    public function it_shoul_find_entity_by_valid_country_code($countryCode, $country, $tax)
    {
        //Givent countryTax Repository
        $em = $this->getContainer()->get(EntityManagerInterface::class);
        /** @var CountryTaxRepository $countryTaxRepo */
        $countryTaxRepo = $em->getRepository(CountryTax::class);

        //When try to find country tax by country code
        $countryTax = $countryTaxRepo->findOneByFormat($countryCode);

        //Then check we have correct entity
        $this->assertNotNull($countryTax);
        $this->assertEquals($country, $countryTax->getCountry());
        $this->assertEquals($tax, $countryTax->getTax());
    }

    public function providerOfNotValidCountryCodes()
    {
        yield 'Germany country code' => ['DEaa3456789', 'Germany', 19];
        yield 'Italy country code' => ['IT123456789115', 'Italy', 22];
        yield 'France country code' => ['FR1M123456789', 'France', 20];
        yield 'Greece country code' => ['GR1234bb789', 'Greece', 24];
        yield 'England country code' => ['GB1234bb789', 'England', 10];
    }

    /**
     * @test
     */
    public function it_shoul_work2()
    {
        //Given countryTax Repository
        $em = $this->getContainer()->get(EntityManagerInterface::class);
        /** @var CountryTaxRepository $countryTaxRepo */
        $countryTaxRepo = $em->getRepository(CountryTax::class);

        //When try to find country tax by invalid country code
        $countryTax = $countryTaxRepo->findOneByFormat('DE12345');

        //Then check we have null object
        $this->assertNull($countryTax);
    }
}