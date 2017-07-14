<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UniteParFormation
 *
 * @ORM\Table(name="UniteParFormation", indexes={@ORM\Index(name="IDX_C1E36CE8A68ED5A2", columns={"CodeFormation"}), @ORM\Index(name="IDX_C1E36CE86837EF81", columns={"IdUniteFormation"})})
 * @ORM\Entity
 */
class UniteParFormation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="Position", type="smallint", nullable=false)
     */
    private $position;

    /**
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $formation;

    /**
     * @var \AppBundle\Entity\UniteFormation
     *
     * @ORM\ManyToOne(targetEntity="UniteFormation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdUniteFormation", referencedColumnName="IdUniteFormation")
     * })
     */
    private $uniteFormation;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UniteParFormation
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return UniteParFormation
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * @param Formation $formation
     * @return UniteParFormation
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
        return $this;
    }

    /**
     * @return UniteFormation
     */
    public function getUniteFormation()
    {
        return $this->uniteFormation;
    }

    /**
     * @param UniteFormation $uniteFormation
     * @return UniteParFormation
     */
    public function setUniteFormation($uniteFormation)
    {
        $this->uniteFormation = $uniteFormation;
        return $this;
    }

}

