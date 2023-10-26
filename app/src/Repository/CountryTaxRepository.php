<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CountryTax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class CountryTaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CountryTax::class);
    }

    public function findOneByFormat(string $format): CountryTax | null
    {
        $rsm = new Query\ResultSetMapping();
        $rsm->addEntityResult(CountryTax::class, 'ct');
        $rsm->addFieldResult('ct', 'country', 'country');
        $rsm->addFieldResult('ct', 'tax', 'tax');
        $rsm->addFieldResult('ct', 'tax_num_format', 'taxNumFormat');


        return $this
            ->getEntityManager()
            ->createNativeQuery('SELECT * FROM country_tax ct WHERE :format SIMILAR TO ct.tax_num_format', $rsm)
            ->setParameter('format', $format)
            ->execute()[0] ?? null;

    }
}