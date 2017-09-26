<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendrier", cascade={"persist", "remove" }, inversedBy="modulesCalendrier")
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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dispense", mappedBy="moduleCalendrier")
     */
    private $dispenses;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Calendrier", mappedBy="modulesCalendrierAPlacer")
     */
    private $calendriersEnAttente;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
        $this->calendriersEnAttente = new ArrayCollection();
    }

    public function getNombreHeuresReel()
    {
        $result = 35;

        foreach ($this->dispenses as $dispense) {
            $interval = date_diff($dispense->getDateFin(), $dispense->getDateDebut(), true);
            if ($interval) {
                $result = $result - ($interval->days + 1);
            }
        }

        return $result;
    }

    /**
     * @return Collection
     */
    public function getDispenses()
    {
        return $this->dispenses;
    }

    /**
     * @param Collection $dispenses
     * @return ModuleCalendrier
     */
    public function setDispenses($dispenses)
    {
        $this->dispenses = $dispenses;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCalendriersEnAttente()
    {
        return $this->calendriersEnAttente;
    }

    /**
     * @param Collection $calendriersEnAttente
     * @return ModuleCalendrier
     */
    public function setCalendriersEnAttente($calendriersEnAttente)
    {
        $this->calendriersEnAttente = $calendriersEnAttente;
        return $this;
    }

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

