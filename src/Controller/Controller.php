<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Slot;
use App\Model\Doctor;
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

    public function getDoctorController(Request $request): JsonResponse
    {
        $doctorId = $request->get('id');
        $doctor = $this->getDoctorById((int)$doctorId);

        if (!$doctor) {
            return new JsonResponse([], 404);
        }

        return new JsonResponse([
            'id' => $doctor->id(),
            'firstName' => $doctor->firstName(),
            'lastName' => $doctor->lastName(),
            'specialization' => $doctor->specialization()->name(),
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

        /** @var Slot[] $slots */
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

    private function getDoctorById(int $doctorId): ?Doctor
    {
        /** @var EntityManagerInterface $man */
        $entityManager = $this->getDoctrine()->getManager();

        return $entityManager->createQueryBuilder()
            ->select('doctor')
            ->from(Doctor::class, 'doctor')
            ->where('doctor.id=:id')
            ->setParameter('id', $doctorId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function createSlotFromRequest(Request $request, Doctor $doctor): Slot
    {
        $slot = new Slot();
        $slot->setDay(new DateTime($request->get('day')));
        $slot->setDoctor($doctor);
        $slot->setDuration((int)$request->get('duration'));
        $slot->setFromHour($request->get('from_hour'));

        return $slot;
    }

    private function saveSlot(Slot $slot): Slot
    {
        /** @var EntityManagerInterface $man */
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($slot);
        $entityManager->flush();

        return $slot;
    }
}
