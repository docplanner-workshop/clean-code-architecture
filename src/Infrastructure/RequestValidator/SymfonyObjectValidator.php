<?php
declare(strict_types=1);

namespace App\Infrastructure\RequestValidator;

use App\Infrastructure\Exception\InvalidRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SymfonyObjectValidator implements RequestValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /** @inheritDoc */
    public function validate(object $data): void
    {
        $errors = $this->validator->validate($data);

        if ($errors->count() > 0) {
            throw new InvalidRequestException($this->parseToArray($errors), Response::HTTP_BAD_REQUEST);
        }
    }

    private function parseToArray(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        /** @var ConstraintViolation $error */
        foreach ($violations as $error) {
            $errors[$error->getPropertyPath()][] = $error->getMessage();
        }

        return $errors;
    }
}
