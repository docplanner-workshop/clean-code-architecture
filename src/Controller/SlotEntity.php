<?php
declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="slot")
 */
final class SlotEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     */
    protected $day;

    /**
     * @ORM\Column(type="string")
     */
    protected $from_hour;

    /**
     * @ORM\Column(type="integer")
     */
    protected $duration;// minutes

    /**
     * @ORM\ManyToOne(targetEntity="DoctorEntity", inversedBy="slots")
     */
    protected $doctor;

    public function getId()
    {
        return $this->id;
    }

    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    public function getFromHour()
    {
        return $this->from_hour;
    }

    /**
     * @param mixed $from_hour
     */
    public function setFromHour($from_hour)
    {
        $this->from_hour = $from_hour;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function doctor()
    {
        return $this->doctor;
    }

    /**
     * @param mixed $doctor
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;
    }

}
