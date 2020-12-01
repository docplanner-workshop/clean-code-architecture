<?php
declare(strict_types=1);

namespace App\Factory;

use App\Model\Doctor;
use App\Action\Input\AddDoctorDTO;

final class DoctorFactory
{
    private SpecializationFactory $specializationFactory;

    public function __construct(SpecializationFactory $specializationFactory)
    {
        $this->specializationFactory = $specializationFactory;
    }

    public function createFromDTO(AddDoctorDTO $doctorData): Doctor
    {
        return new Doctor(
            $doctorData->firstName(),
            $doctorData->lastName(),
            $this->specializationFactory->create($doctorData->specialization())
        );
    }
}
