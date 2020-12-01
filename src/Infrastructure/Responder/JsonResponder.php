<?php
declare(strict_types=1);

namespace App\Infrastructure\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * This is just one of the ways of serializing to json. This works only if the DTO uses get{FieldName} methods.
 * If you would implement all of the response DTOs as JsonSerializable and use json_encode, it would be faster, as these are native
 * php mechanisms. SymfonySerializer needs a lot of Performance Attention as it can be a bottleneck if the used normalizer
 * is low performing
 */
final class JsonResponder
{
    /** @var SerializerInterface */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(ViewEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(
                $this->serializer->serialize($event->getControllerResult(), 'json'),
                JsonResponse::HTTP_OK, // You could make it dynamic, using some annotations on the controller result in php 8
                [],
                true
            )
        );
    }
}
