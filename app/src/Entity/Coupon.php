<?php

declare(strict_types=1);

namespace App\Entity;

use App\Service\PriceCalculator\CouponTypeEnum;
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

    #[ORM\Column(enumType: CouponTypeEnum::class)]
    private CouponTypeEnum $type;

    public function getType(): CouponTypeEnum
    {
        return $this->type;
    }

    public function setType(CouponTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

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