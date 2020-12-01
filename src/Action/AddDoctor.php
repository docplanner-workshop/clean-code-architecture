<?php
declare(strict_types=1);

namespace App\Action;

use App\Action\Input\AddDoctorDTO;
use App\Action\Output\DoctorAddedResponse;
use App\Factory\DoctorFactory;
use App\Model\Doctors;

final class AddDoctor
{
    private Doctors $doctors;

    private DoctorFactory $doctorFactory;

    public function __construct(Doctors $doctors, DoctorFactory $doctorFactory)
    {
        $this->doctors = $doctors;
        $this->doctorFactory = $doctorFactory;
    }

    public function __invoke(AddDoctorDTO $addDoctorDTO): DoctorAddedResponse
    {
        $doctor = $this->doctorFactory->createFromDTO($addDoctorDTO);

        $this->doctors->add($doctor);

        return new DoctorAddedResponse($doctor);
    }
}
