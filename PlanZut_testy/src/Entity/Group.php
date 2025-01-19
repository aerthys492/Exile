<?php

namespace Patryk\PlanZut;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id_group;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $group_name;

    public function getIdGroup(): ?int
    {
        return $this->id_group;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(string $group_name): self
    {
        $this->group_name = $group_name;

        return $this;
    }
}
