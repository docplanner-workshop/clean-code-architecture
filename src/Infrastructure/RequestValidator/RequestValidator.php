<?php
declare(strict_types=1);

namespace App\Infrastructure\RequestValidator;

use App\Infrastructure\Exception\InvalidRequestException;

interface RequestValidator
{
    /** @throws InvalidRequestException */
    public function validate(object $data): void;
}
