<?php

declare(strict_types=1);

namespace App\Tests\Unit\Request;

use App\Request\PriceCalculateRequest;
use App\Request\RequestErrorsHandlerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceCalculateRequestTest extends TestCase
{
    /** @test */
    public function it_should_give_request_object_with_valid_data_if_no_validation_errors()
    {
        //Given .... new request for price calculation endpoint
        $request = $this->createStub(Request::class);
        $request->method('toArray')
            ->willReturn(['productId' => 1, 'taxNumber' => 'GR123456789', 'couponCode' => 'promo6']);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->any())
            ->method('validate')
            ->willReturn(new ConstraintViolationList());
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects($this->any())
            ->method('getCurrentRequest')
            ->willReturn($request);
        $errorsHandler = $this->createMock(RequestErrorsHandlerInterface::class);
        $errorsHandler->expects($this->never())
            ->method('handle');

        //When request data valid
        $request = new PriceCalculateRequest($validator, $requestStack, $errorsHandler);

        //Then check that we get all request data in PriceCalculateRequest
        $this->assertEquals('promo6', $request->couponCode);
        $this->assertEquals('GR123456789', $request->taxNumber);
        $this->assertEquals(1, $request->productId);
    }

    /** @test */
    public function it_should_call_request_error_handler_handle_if_some_error_happened()
    {
        //Given .... new request for price calculation endpoint
        $request = $this->createStub(Request::class);
        $request->method('toArray')
            ->willReturn(['productId' => -100, 'taxNumber' => 'GR123456789']);

        //$violationsList = $this->createStub(ConstraintViolationListInterface::class);
        $validator = $this->createStub(ValidatorInterface::class);
        $validator->method('validate')
            ->willReturn(new ConstraintViolationList([new ConstraintViolation(message: 'productId is wrong', propertyPath: 'productId', invalidValue: 'not valid', messageTemplate: '', parameters: [], root: '')]));
        $requestStack = $this->createStub(RequestStack::class);
        $requestStack->method('getCurrentRequest')
            ->willReturn($request);
        $errorsHandler = $this->createMock(RequestErrorsHandlerInterface::class);
        $errorsHandler->expects($this->once())
            ->method('handle')
            ->with([[
                'property' => 'productId',
                'value' => 'not valid',
                'message' => 'productId is wrong'
        ]]);

        //When request data valid
        new PriceCalculateRequest($validator, $requestStack, $errorsHandler);

        //Then check that we get all request data in PriceCalculateRequest
    }

    /** @test */
    public function it_should_call_request_error_handler_handle_if_wrong_type()
    {
        //Given .... new request for price calculation endpoint
        $request = $this->createStub(Request::class);
        $request->method('toArray')
            ->willReturn(['productId' => 'not valid', 'taxNumber' => 'GR123456789']);


        $validator = $this->createStub(ValidatorInterface::class);
        $requestStack = $this->createStub(RequestStack::class);
        $requestStack->method('getCurrentRequest')
            ->willReturn($request);
        $errorsHandler = $this->createMock(RequestErrorsHandlerInterface::class);

        $errorsHandler->expects($this->once())
            ->method('handle')
            ->with([[
                'property' => 'productId',
                'value' => 'not valid',
                'message' => 'Wrong parameter type'
            ]]);

        //When request data valid
        new PriceCalculateRequest($validator, $requestStack, $errorsHandler);

        //Then check that we get all request data in PriceCalculateRequest
    }
}
