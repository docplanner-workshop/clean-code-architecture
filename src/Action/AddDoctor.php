<?php
declare(strict_types=1);

namespace App\Action;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\DoctorEntity;

final class AddDoctor
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function __invoke(Request $request): JsonResponse
    {
        $newDoctor = $this->createDoctorFromRequest($request);
        $doctor = $this->saveDoctor($newDoctor);

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
    private function saveDoctor(DoctorEntity $doctor): DoctorEntity
    {
        /** @var EntityManagerInterface $man */
        $entityManager = $this->entityManager;
        $entityManager->persist($doctor);
        $entityManager->flush();

        return $doctor;
    }
}
