<?php
declare(strict_types=1);

namespace App\Action\Input;

final class AddDoctorDTO
{
    private string $firstName;

    private string $lastName;

    private string $specialization;

    public function __construct(
        string $firstName,
        string $lastName,
        string $specialization
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->specialization = $specialization;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function specialization(): string
    {
        return $this->specialization;
    }
}
