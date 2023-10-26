<?php

declare(strict_types=1);

namespace App\Entity;

use App\Service\Purchase\PaymentProcessorEnum;
use App\Service\Purchase\PaymentStatusEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PurchaseRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
#[ORM\Table(name:'purchases')]
#[ORM\HasLifecycleCallbacks]
class Purchase
{
    #[ORM\Id]
    #[ORM\Column, ORM\GeneratedValue('IDENTITY')]
    private int $id;

    #[ORM\Column]
    private int $sum;

    #[ORM\Column(name:'tax_number')]
    private string $taxNumber;

    #[ORM\Column(name:'tax_rate')]
    private int $taxRate;

    #[ORM\Column(name:'coupon_code', nullable: true)]
    private string|null $couponCode;

    #[ORM\Column(name:'coupon_discount', nullable: true)]
    private int|null $couponDiscount;

    #[ORM\Column(name:'created_at')]
    private \DateTime $createdAt;

    #[ORM\Column(name:'product_id')]
    private int $productId;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, unique: false, onDelete: 'RESTRICT')]
    private Product $product;

    #[ORM\Column(name:'payment_processor', enumType: PaymentProcessorEnum::class)]
    private PaymentProcessorEnum $paymentProcessor;

    #[ORM\Column(name:'payment_status', enumType: PaymentStatusEnum::class)]
    private PaymentStatusEnum $paymentStatus;

    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args):void
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): self
    {
        $this->sum = $sum;
        return $this;
    }

    public function getPaymentProcessor(): PaymentProcessorEnum
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(PaymentProcessorEnum $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;
        return $this;
    }

    public function getPaymentStatus(): PaymentStatusEnum
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(PaymentStatusEnum $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;
        return $this;
    }


    public function getTaxRate(): int
    {
        return $this->taxRate;
    }

    public function setTaxRate(int $taxRate): self
    {
        $this->taxRate = $taxRate;
        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(?string $couponCode): self
    {
        $this->couponCode = $couponCode;
        return $this;
    }

    public function getCouponDiscount(): ?int
    {
        return $this->couponDiscount;
    }

    public function setCouponDiscount(?int $couponDiscount): self
    {
        $this->couponDiscount = $couponDiscount;
        return $this;
    }



}