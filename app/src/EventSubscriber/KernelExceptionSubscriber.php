<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;


class KernelExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $responseStatus = match($exception::class) {
            BadRequestHttpException::class => Response::HTTP_BAD_REQUEST,
            NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };

        $customResponse = new JsonResponse(
            ['errors' => [$exception->getMessage()]],
            $responseStatus
        );

        $event->setResponse($customResponse);
    }

    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException']
            ]
        ];
    }


}