<?php

declare(strict_types=1);

namespace App\Request;

use App\Validator\TaxConstraint;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceCalculateRequest extends BaseRequest
{
    #[NotBlank]
    public readonly int $productId;

    #[NotBlank]
    #[TaxConstraint]
    public readonly string $taxNumber;

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