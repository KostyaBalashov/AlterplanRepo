<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleParUnite
 *
 * @ORM\Table(name="ModuleParUnite")
 * @ORM\Entity
 */
class ModuleParUnite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="Position", type="smallint", nullable=false)
     */
    private $position;

    /**
     * @var \AppBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")
     * })
     */
    private $module;

    /**
     * @var \AppBundle\Entity\UniteParFormation
     *
     * @ORM\ManyToOne(targetEntity="UniteParFormation", inversedBy="modulesParUnite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdUnite", referencedColumnName="Id")
     * })
     */
    private $uniteParFormation;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ModuleParUnite
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
     * @return ModuleParUnite
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param Module $module
     * @return ModuleParUnite
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return UniteParFormation
     */
    public function getUniteParFormation()
    {
        return $this->uniteParFormation;
    }

    /**
     * @param UniteParFormation $uniteParFormation
     * @return ModuleParUnite
     */
    public function setUniteParFormation($uniteParFormation)
    {
        $this->uniteParFormation = $uniteParFormation;
        return $this;
    }

}

