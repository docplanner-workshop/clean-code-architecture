<?php
declare(strict_types=1);

namespace App\Infrastructure\ExceptionHandler;

use App\Infrastructure\Exception\InvalidRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class InvalidRequestExceptionHandler
{
    public function __invoke(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof InvalidRequestException) {
            $event->setResponse(
                new JsonResponse($exception->errors(), $exception->getCode())
            );
        }
    }
}
