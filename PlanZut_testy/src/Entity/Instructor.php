<?php
namespace Patryk\PlanZut;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lecturer")
 */
class Instructor
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_lecturer;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $surname;

    // Gettery i settery
    public function getId(): int
    {
        return $this->id_lecturer;
    }

    public function getname(): string
    {
        return $this->name;
    }

    public function setname(string $name): void
    {
        $this->name = $name;
    }

    public function getsurname(): string
    {
        return $this->surname;
    }

    public function setsurname(string $surname): void
    {
        $this->surname = $surname;
    }
}
