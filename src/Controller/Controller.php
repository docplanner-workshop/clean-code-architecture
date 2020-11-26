<?php
declare(strict_types=1);

namespace App\Controller;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractController
{

    function index()
    {
        return new JsonResponse('ReallyDirty API v1.0');
    }

    function addDoctorController(Request $request): JsonResponse
    {
        $newDoctor = $this->createDoctorFromRequest($request);
        $doctor = $this->saveDoctor($newDoctor);

        return new JsonResponse(['id' => $doctor->getId()]);
    }

    public function getDoctorController(Request $request): JsonResponse
    {
        $doctorId = $request->get('id');
        $doctor = $this->getDoctorById((int)$doctorId);

        if (!$doctor) {
            return new JsonResponse([], 404);
        }

        return new JsonResponse([
            'id' => $doctor->getId(),
            'firstName' => $doctor->getFirstName(),
            'lastName' => $doctor->getLastName(),
            'specialization' => $doctor->getSpecialization(),
        ]);
    }

    function addSlotController(string $doctorId, Request $request): JsonResponse
    {
        $doctor = $this->getDoctorById((int)$doctorId);

        if (!$doctor) {
            return new JsonResponse([], 404);
        }

        $newSlot = $this->createSlotFromRequest($request, $doctor);
        $slot = $this->saveSlot($newSlot);

        return new JsonResponse(['id' => $slot->getId()]);
    }

    function getSlotsController(int $doctorId): JsonResponse
    {
        $doctor = $this->getDoctorById((int)$doctorId);
        if (null === $doctor) {
            return new JsonResponse([], 404);
        }

        /** @var SlotEntity[] $slots */
        $slots = $doctor->slots();

        $res = [];
        foreach ($slots as $slot) {
            $res[] = [
                'id' => $slot->getId(),
                'day' => $slot->getDay()->format('Y-m-d'),
                'from_hour' => $slot->getFromHour(),
                'duration' => $slot->getDuration()
            ];
        }

        return new JsonResponse($res);
    }

    private function getDoctorById(int $doctorId): ?DoctorEntity
    {
        /** @var EntityManagerInterface $man */
        $entityManager = $this->getDoctrine()->getManager();

        return $entityManager->createQueryBuilder()
            ->select('doctor')
            ->from(DoctorEntity::class, 'doctor')
            ->where('doctor.id=:id')
            ->setParameter('id', $doctorId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function createSlotFromRequest(Request $request, DoctorEntity $doctor): SlotEntity
    {
        $slot = new SlotEntity();
        $slot->setDay(new DateTime($request->get('day')));
        $slot->setDoctor($doctor);
        $slot->setDuration((int)$request->get('duration'));
        $slot->setFromHour($request->get('from_hour'));

        return $slot;
    }

    private function saveSlot(SlotEntity $slot): SlotEntity
    {
        /** @var EntityManagerInterface $man */
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($slot);
        $entityManager->flush();

        return $slot;
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
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($doctor);
        $entityManager->flush();

        return $doctor;
    }
}
