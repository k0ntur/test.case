<?php

namespace App\DataFixtures;

use App\Entity\CountryTax;
use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productIphone = new Product();
        $manager->persist($productIphone);

        $productIphone->setName('Iphone')
            ->setPrice(100_00);

        $productEarphones = new Product();
        $manager->persist($productEarphones);

        $productEarphones->setName('Наушники')
            ->setPrice(20_00);

        $productPhonecase = new Product();
        $manager->persist($productPhonecase);

        $productPhonecase->setName('Чехол')
            ->setPrice(10_00);

        $productPhonecase = new Product();
        $manager->persist($productPhonecase);

        $productPhonecase->setName('MackBook')
            ->setPrice(1500_00);


        $coupon6 = new Coupon();
        $manager->persist($coupon6);
        $coupon6->setCode('promo6')
            ->setDiscount(6);

        $coupon10 = new Coupon();
        $manager->persist($coupon10);
        $coupon10->setCode('promo10')
            ->setDiscount(10);

        $coupon15 = new Coupon();
        $manager->persist($coupon15);
        $coupon15->setCode('promo15')
            ->setDiscount(15);


        $countryTaxGer = new CountryTax();
        $countryTaxGer
            ->setCountry('Germany')
            ->setTax(19)
            ->setTaxNumFormat('DE\d{9}');
        $manager->persist($countryTaxGer);

        $countryTaxFrance = new CountryTax();
        $countryTaxFrance
            ->setCountry('France')
            ->setTax(20)
            ->setTaxNumFormat('FR[a-zA-Z]{2}\d{9}');
        $manager->persist($countryTaxFrance);

        $countryTaxItaly = new CountryTax();
        $countryTaxItaly
            ->setCountry('Italy')
            ->setTax(22)
            ->setTaxNumFormat('IT\d{11}');
        $manager->persist($countryTaxItaly);

        $countryTaxGreece = new CountryTax();
        $countryTaxGreece
            ->setCountry('Greece')
            ->setTax(24)
            ->setTaxNumFormat('GR\d{9}');
        $manager->persist($countryTaxGreece);

        $manager->flush();
    }
}
