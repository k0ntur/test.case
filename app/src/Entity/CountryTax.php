<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CountryTaxRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: CountryTaxRepository::class)]
#[Table(name:'country_tax')]
class CountryTax
{
    #[Id]
    #[Column(unique: true, nullable: false)]
    private string $country;

    #[Column]
    private int $tax;

    #[Column(name:'tax_num_format')]
    private string $taxNumFormat;

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getTax(): int
    {
        return $this->tax;
    }

    public function setTax(int $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function getTaxNumFormat(): string
    {
        return $this->taxNumFormat;
    }

    public function setTaxNumFormat(string $taxNumFormat): self
    {
        $this->taxNumFormat = $taxNumFormat;
        return $this;
    }
}