<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CouponRepository;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table(name:'coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue('IDENTITY')]
    private int $id;

    #[ORM\Column]
    private int $discount;

    #[ORM\Column]
    private string $code;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}