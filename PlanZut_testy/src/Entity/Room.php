<?php

namespace Patryk\PlanZut;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="class")
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_class;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $class_name;

    public function getIdClass(): ?int
    {
        return $this->id_class;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    public function getClassName(): ?string
    {
        return $this->class_name;
    }

    public function setClassName(string $roomName): void
    {
        $this->class_name = $roomName;
    }
}
