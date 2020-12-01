<?php
declare(strict_types=1);

namespace App\Model;

interface Doctors
{
    public function add(Doctor $doctor): void;
}
