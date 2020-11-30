<?php
declare(strict_types=1);

namespace App\Model;

use App\Controller\DoctorEntity;

interface Doctors
{
    public function add(DoctorEntity $doctor): void;
}
