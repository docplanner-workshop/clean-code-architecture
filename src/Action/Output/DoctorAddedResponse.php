<?php
declare(strict_types=1);

namespace App\Action\Output;

use App\Model\Doctor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DoctorAddedResponse extends JsonResponse
{
    public function __construct(Doctor $doctor)
    {
        parent::__construct([
            'id' => $doctor->id()
        ], Response::HTTP_CREATED);
    }
}
