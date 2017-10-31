<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleCalendrier
 *
 * @ORM\Table(name="ModuleCalendrier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleCalendrierRepository")
 */
class ModuleCalendrier implements \JsonSerializable
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
     * @var \DateTime
     * @ORM\Column(name="dateDebut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateFin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     * @ORM\Column(name="libelle", type="string", nullable=true)
     */
    private $libelle;

    /**
     * @var int
     * @ORM\Column(name="nbSemaines", type="integer", nullable=false)
     */
    private $nbSemaines = 0;

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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dispense", mappedBy="moduleCalendrier",  fetch="EAGER")
     */
    private $dispenses;

    public function __construct()
    {
        $this->dispenses = new ArrayCollection();
    }

    public function getNombreHeuresReel()
    {
        $result = 0;

        if ($this->dateDebut && $this->dateFin) {
            $result = date_diff($this->dateFin, $this->dateDebut, true);;

            foreach ($this->dispenses as $dispense) {
                $interval = date_diff($dispense->getDateFin(), $dispense->getDateDebut(), true);
                if ($interval) {
                    $result = $result - ($interval->days + 1);
                }
            }
        }

        return $result;
    }

    public function jsonSerialize()
    {
        $result = [];

        $result['codeModuleCalendrier'] = $this->codeModuleCalendrier;
        $result['codeCalendrier'] = $this->calendrier->getCodeCalendrier();
        $result['nbHeures'] = $this->getNombreHeuresReel();
        $result['dateDebut'] = json_encode($this->dateDebut);
        $result['dateFin'] = json_encode($this->dateFin);
        $result['libelle'] = $this->libelle;
        $result['module'] = $this->module->jsonSerialize();
        $result['dispenses'] = json_encode($this->dispenses->toArray());

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
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     * @return ModuleCalendrier
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     * @return ModuleCalendrier
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     * @return ModuleCalendrier
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbSemaines()
    {
        return $this->nbSemaines;
    }

    /**
     * @param int $nbSemaines
     * @return ModuleCalendrier
     */
    public function setNbSemaines($nbSemaines)
    {
        $this->nbSemaines = $nbSemaines;
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

}

