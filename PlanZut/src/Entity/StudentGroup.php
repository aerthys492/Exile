<?php

namespace Patryk\PlanZut;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="student_group")
 */
class StudentGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $id_student;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private int $id_group;

    public function getIdStudent(): int
    {
        return $this->id_student;
    }

    public function setIdStudent(int $id_student): void
    {
        $this->id_student = $id_student;
    }

    public function getIdGroup(): int
    {
        return $this->id_group;
    }

    public function setIdGroup(int $id_group): void
    {
        $this->id_group = $id_group;
    }
}
