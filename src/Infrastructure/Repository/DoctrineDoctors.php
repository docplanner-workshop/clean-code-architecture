<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Controller\DoctorEntity;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineDoctors
{
    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(DoctorEntity $doctor): void
    {
        $this->entityManager->persist($doctor);
        $this->entityManager->flush();
    }
}
