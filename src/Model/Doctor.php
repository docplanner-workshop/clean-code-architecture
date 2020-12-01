<?php
declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * @ORM\Entity
 * @ORM\Table(name="doctor")
 */
class Doctor extends Entity
{
    /**
     * @ORM\Column(type="string")
     */
    protected string $firstName;

    /**
     * @ORM\Column(type="string")
     */
    protected string $lastName;

    /**
     * @ORM\Embedded(class="App\Model\Specialization", columnPrefix="specialization_")
     */
    protected Specialization $specialization;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="doctor")
     * @var Slot[]|Collection
     */
    protected Collection $slots;

    public function __construct(string $firstName, string $lastName, Specialization $specialization)
    {
        $this->changeFirstName($firstName);
        $this->changeLastName($lastName);
        $this->slots = new ArrayCollection();
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

    public function fullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    public function changeFirstName(string $firstName): void
    {
        if (strlen($firstName) === 0) {
            throw new DomainException('Doctor first name cannot be empty');
        }

        $this->firstName = $firstName;
    }

    public function specialization(): Specialization
    {
        return $this->specialization;
    }

    private function changeLastName(string $lastName): void
    {
        if (strlen($lastName) === 0) {
            throw new DomainException('Doctor last name cannot be empty');
        }

        $this->lastName = $lastName;
    }

    /**
     * @return Slot[]|Collection
     */
    public function slots()
    {
        return $this->slots;
    }
}
