<?php
declare(strict_types=1);

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class InvalidRequestException extends BadRequestHttpException
{
    private array $errors;

    public function __construct(array $errors, int $httpCode)
    {
        $this->errors = $errors;
        parent::__construct("", null, $httpCode);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
