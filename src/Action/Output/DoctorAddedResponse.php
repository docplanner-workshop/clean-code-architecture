<?php
declare(strict_types=1);

namespace App\Action\Output;

use App\Controller\DoctorEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DoctorAddedResponse extends JsonResponse
{
    public function __construct(DoctorEntity $doctor)
    {
        parent::__construct([
            'id' => $doctor->getId()
        ], Response::HTTP_CREATED);
    }
}
