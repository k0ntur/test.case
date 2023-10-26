<?php

namespace App\Request;

use App\Service\Purchase\PaymentProcessorEnum;
use App\Validator\TaxConstraint;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseRequest extends BaseRequest
{
   #[NotBlank]
   public readonly int $productId;

   #[NotBlank]
   #[TaxConstraint]
   public readonly string $taxNumber;

    #[NotBlank]
    #[Choice(callback: [PaymentProcessorEnum::class, 'getProcessors'])]
    public readonly string $paymentProcessor;

    public readonly string $couponCode;

    public function __construct(
        ValidatorInterface $validator,
        RequestStack $requestStack,
        RequestErrorsHandlerInterface $errorsHandler
    )
    {
        parent::__construct($validator, $requestStack, $errorsHandler);

        if (!isset($this->couponCode)) {
            $this->couponCode = "";
        }
    }
}