<?php
declare(strict_types=1);

namespace App\Action;

use App\Controller\DoctorEntity;
use App\Model\Doctors;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class AddDoctor
{
    private Doctors $doctors;

    public function __construct(Doctors $doctors)
    {
        $this->doctors = $doctors;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $doctor = $this->createDoctorFromRequest($request);

        $this->doctors->add($doctor);

        return new JsonResponse(['id' => $doctor->getId()]);
    }

    private function createDoctorFromRequest(Request $request): DoctorEntity
    {
        $doctor = new DoctorEntity();
        $doctor->setFirstName($request->get('firstName'));
        $doctor->setLastName($request->get('lastName'));
        $doctor->setSpecialization($request->get('specialization'));

        return $doctor;
    }
}
