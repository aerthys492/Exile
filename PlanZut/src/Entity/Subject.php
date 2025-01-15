<?php

namespace Patryk\PlanZut;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subject")

 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_subject;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject_department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject_direction;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $subject_study_type;

    public function getIdSubject(): ?int
    {
        return $this->id_subject;
    }

    public function getSubjectName(): ?string
    {
        return $this->subject_name;
    }

    public function setSubjectName(string $subjectName): void
    {
        $this->subject_name = $subjectName;
    }

    public function getSubjectDepartment(): ?string
    {
        return $this->subject_department;
    }

    public function setSubjectDepartment(string $subjectDepartment): void
    {
        $this->subject_department = $subjectDepartment;
    }

    public function getSubjectDirection(): ?string
    {
        return $this->subject_direction;
    }

    public function setSubjectDirection(string $subjectDirection): void
    {
        $this->subject_direction = $subjectDirection;
    }

    public function getSubjectStudyType(): ?string
    {
        return $this->subject_study_type;
    }

    public function setSubjectStudyType(string $subjectStudyType): void
    {
        $this->subject_study_type = $subjectStudyType;
    }
}
