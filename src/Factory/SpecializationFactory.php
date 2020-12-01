<?php
declare(strict_types=1);

namespace App\Factory;

use App\Model\Specialization;

final class SpecializationFactory
{
    public function create(string $specialization): Specialization
    {
        return new Specialization($specialization);
    }
}
