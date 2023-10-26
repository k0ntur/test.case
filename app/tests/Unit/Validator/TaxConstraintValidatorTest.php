<?php

declare(strict_types=1);

namespace App\Tests\Unit\Validator;

use App\Repository\CountryTaxRepository;
use App\Validator\TaxConstraint;
use App\Validator\TaxConstraintValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

#TODO: нужно установить intl для работы данного теста....
/**
 * @requires extension intl
 */
class TaxConstraintValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        $mockTaxRepository = $this->createMock(CountryTaxRepository::class);
        return new TaxConstraintValidator($mockTaxRepository);
    }

    /** @test */
    public function it_should_give_exception_if_null_value(): void
    {
        //Given with constraint
        $constraint = new TaxConstraint();

        $this->expectException(UnexpectedValueException::class);

        //When trying to validate null value
        $this->validator->validate(null, $constraint);

        //Then get the Exception
    }

    /**
     * @test
     * @dataProvider provideInvalidConstraints
     */
    public function it_should_give_invalid(TaxConstraint $constraint): void
    {
        //Given with data from data provider

        //When
        $this->validator->validate('...', $constraint);

        //Then
        $this->buildViolation('Tax Number {{ string }} incorrect')
            ->setParameter('{{ string }}', '...')
            ->assertRaised();
    }

    public function provideInvalidConstraints(): iterable
    {
        yield [new TaxConstraint()];
        // ...
    }
}