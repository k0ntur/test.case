<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseRequest
{
    private array $errors = [];

    public function __construct(
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack,
        protected RequestErrorsHandlerInterface $errorsHandler
    ) {
        $this->populate();
        $this->validate();
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function populate(): void
    {
        $request = $this->getRequest();
        $reflection = new \ReflectionClass($this);

        foreach ($request->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $reflectionProperty = $reflection->getProperty($property);
                try {
                    $reflectionProperty->setValue($this, $value);
                } catch (\TypeError $e){
                    $this->errors[$reflectionProperty->getName()] = sprintf('Property `%s` = `%s` has wrong parameter type', $reflectionProperty->getName(), $value);
                }
            }
        }
    }

    protected function validate(): void
    {
        $violations = $this->validator->validate($this);
        if (count($violations) == 0) {
            return;
        }

        /** @var \Symfony\Component\Validator\ConstraintViolation */
        foreach ($violations as $violation) {
            $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        $this->errorsHandler->handle($this->errors);
    }
}