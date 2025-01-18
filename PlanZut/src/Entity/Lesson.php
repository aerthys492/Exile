<?php
namespace Patryk\PlanZut;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="lessons")
 */
class Lesson
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_lessons;

    /**
     * @ORM\ManyToOne(targetEntity="Patryk\PlanZut\Subject")
     * @ORM\JoinColumn(name="id_subject", referencedColumnName="id_subject")
     */
    private $id_subject;

    /**
     * @ORM\ManyToOne(targetEntity="Patryk\PlanZut\Instructor")
     * @ORM\JoinColumn(name="id_lecturer", referencedColumnName="id_lecturer")
     */
    private $id_lecturer;

    /**
     * @ORM\ManyToOne(targetEntity="Patryk\PlanZut\Room")
     * @ORM\JoinColumn(name="id_class", referencedColumnName="id_class")
     */
    private $id_class;

    /**
     * @ORM\ManyToOne(targetEntity="Patryk\PlanZut\Group")
     * @ORM\JoinColumn(name="id_group", referencedColumnName="id_group")
     */
    private $id_group;

    /**
     * @ORM\Column(type="date")
     */
    private $date_lessons;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $time_end;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $description;

    // Gettery i settery
    public function getIdLessons(): int
    {
        return $this->id_lessons;
    }

    public function getIdSubject(): ?Subject
    {
        return $this->id_subject;
    }

    public function setIdSubject(?Subject $id_subject): void
    {
        $this->id_subject = $id_subject;
    }

    public function getIdLecturer(): ?Instructor
    {
        return $this->id_lecturer;
    }

    public function setIdLecturer(?Instructor $id_lecturer): void
    {
        $this->id_lecturer = $id_lecturer;
    }

    public function getIdClass(): ?Room
    {
        return $this->id_class;
    }

    public function setIdClass(?Room $id_class): void
    {
        $this->id_class = $id_class;
    }

    public function getIdGroup(): ?Group
    {
        return $this->id_group;
    }

    public function setIdGroup(?Group $id_group): void
    {
        $this->id_group = $id_group;
    }

    public function getDateLessons(): ?DateTime
    {
        return $this->date_lessons;
    }

    public function setDateLessons(DateTime $date_lessons): void
    {
        $this->date_lessons = $date_lessons;
    }

    public function getTimeStart(): ?DateTime
    {
        return $this->time_start;
    }

    public function setTimeStart(DateTime $time_start): void
    {
        $this->time_start = $time_start;
    }

    public function getTimeEnd(): ?DateTime
    {
        return $this->time_end;
    }

    public function setTimeEnd(DateTime $time_end): void
    {
        $this->time_end = $time_end;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
