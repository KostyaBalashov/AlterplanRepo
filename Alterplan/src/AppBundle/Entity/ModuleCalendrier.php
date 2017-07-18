<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleCalendrier
 *
 * @ORM\Table(name="ModuleCalendrier")
 * @ORM\Entity
 */
class ModuleCalendrier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeModuleCalendrier", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeModuleCalendrier;

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
     * @var \AppBundle\Entity\Calendrier
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeCalendrier", referencedColumnName="CodeCalendrier")
     * })
     */
    private $calendrier;

    /**
     * @var Cours
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cours", fetch="LAZY")
     * @ORM\JoinColumn(name="IdCours", referencedColumnName="IdCours", nullable=true)
     */
    private $cours;

    /**
     * @return int
     */
    public function getCodeModuleCalendrier()
    {
        return $this->codeModuleCalendrier;
    }

    /**
     * @param int $codeModuleCalendrier
     * @return ModuleCalendrier
     */
    public function setCodeModuleCalendrier($codeModuleCalendrier)
    {
        $this->codeModuleCalendrier = $codeModuleCalendrier;
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
     * @return ModuleCalendrier
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return Calendrier
     */
    public function getCalendrier()
    {
        return $this->calendrier;
    }

    /**
     * @param Calendrier $calendrier
     * @return ModuleCalendrier
     */
    public function setCalendrier($calendrier)
    {
        $this->calendrier = $calendrier;
        return $this;
    }

    /**
     * @return Cours
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * @param Cours $cours
     * @return ModuleCalendrier
     */
    public function setCours($cours)
    {
        $this->cours = $cours;
        return $this;
    }


}

