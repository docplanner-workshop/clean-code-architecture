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

    function doctorAddController(Request $request)
    {
        $man = $this->getDoctrine()->getManager();

        $doctor = new DoctorEntity();
        $doctor->setFirstName($request->get('firstName'));
        $doctor->setLastName($request->get('lastName'));
        $doctor->setSpecialization($request->get('specialization'));

        $man->persist($doctor);
        $man->flush();

// result
        return new JsonResponse(['id' => $doctor->getId()]);
    }

    public function doctorGetController(Request $request)
    {
        $id = $request->get('id');
        $doctor = $this->getDoctorById((int)$id);

        if ($doctor) {
            return new JsonResponse([
                'id' => $doctor->getId(),
                'firstName' => $doctor->getFirstName(),
                'lastName' => $doctor->getLastName(),
                'specialization' => $doctor->getSpecialization(),
            ]);
        } else {
            return new JsonResponse([], 404);
        }
    }

    function slotAddController(string $doctorId, Request $request)
    {
        $doc = $this->getDoctorById((int)$doctorId);

        if ($doc) {
            /** @var EntityManagerInterface $man */
            $man = $this->getDoctrine()->getManager();

            $slot = new SlotEntity();
            $slot->setDay(new DateTime($request->get('day')));
            $slot->setDoctor($doc);
            $slot->setDuration((int)$request->get('duration'));
            $slot->setFromHour($request->get('from_hour'));

            $man->persist($slot);
            $man->flush();

            return new JsonResponse(['id' => $slot->getId()]);
        } else {
            return new JsonResponse([], 404);
        }
    }

    function slotsGetController(int $doctorId, Request $request)
    {
        $doc = $this->getDoctorById((int)$doctorId);
        if (null === $doc) {
            return new JsonResponse([], 404);
        }
        /** @var SlotEntity[] $array */
        $array = $doc->slots();

        if (count($array)) {
            $res = [];
            foreach ($array as $slot) {
                $res[] = [
                    'id' => $slot->getId(),
                    'day' => $slot->getDay()->format('Y-m-d'),
                    'from_hour' => $slot->getFromHour(),
                    'duration' => $slot->getDuration()
                ];
            }
            return new JsonResponse($res);
        } else {
            return new JsonResponse([]);
        }
    }

    private function getDoctorById(int $id): ?DoctorEntity
    {
        /** @var EntityManagerInterface $man */
        $man = $this->getDoctrine()->getManager();

        return $man->createQueryBuilder()
            ->select('doctor')
            ->from(DoctorEntity::class, 'doctor')
            ->where('doctor.id=:id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
