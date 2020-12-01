<?php
declare(strict_types=1);

namespace App\Factory;

use App\Controller\DoctorEntity;
use App\Action\Input\AddDoctorDTO;

final class DoctorFactory
{
    public function createFromDTO(AddDoctorDTO $doctorData): DoctorEntity
    {
        $doctor = new DoctorEntity();
        $doctor->setFirstName($doctorData->firstName());
        $doctor->setLastName($doctorData->lastName());
        $doctor->setSpecialization($doctorData->specialization());

        return $doctor;
    }
}
