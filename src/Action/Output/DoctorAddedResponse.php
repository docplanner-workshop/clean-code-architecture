<?php
declare(strict_types=1);

namespace App\Action\Output;

use App\Model\Doctor;

final class DoctorAddedResponse
{
    private int $id;

    public function __construct(Doctor $doctor)
    {
        $this->id = $doctor->id();
    }

    public function getId(): int
    {
        return $this->id;
    }
}
