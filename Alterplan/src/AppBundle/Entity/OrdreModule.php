<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdreModule
 *
 * @ORM\Table(name="OrdreModule")
 * @ORM\Entity
 */
class OrdreModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrdreModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeOrdreModule;

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
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $formation;

    /**
     * @return int
     */
    public function getCodeOrdreModule()
    {
        return $this->codeOrdreModule;
    }

    /**
     * @param int $codeOrdreModule
     * @return OrdreModule
     */
    public function setCodeOrdreModule($codeOrdreModule)
    {
        $this->codeOrdreModule = $codeOrdreModule;
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
     * @return OrdreModule
     */
    public function setModule($module)
    {
        $this->module = $module;
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
     * @return OrdreModule
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
        return $this;
    }

}

