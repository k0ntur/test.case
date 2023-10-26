<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\CountryTaxRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TaxConstraintValidator extends ConstraintValidator
{
    public function __construct(
        private CountryTaxRepository $repository
    )
    {

    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof TaxConstraint) {
            throw new UnexpectedTypeException($constraint, TaxConstraint::class);
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if ($this->repository->findOneByFormat($value) != null) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}