<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dispense
 *
 * @ORM\Table(name="Dispense")
 * @ORM\Entity
 */
class Dispense implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeDispense", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeDispense;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var \AppBundle\Entity\ModuleCalendrier
     *
     * @ORM\ManyToOne(targetEntity="ModuleCalendrier", inversedBy="dispenses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeModuleCalendrier", referencedColumnName="CodeModuleCalendrier")
     * })
     */
    private $moduleCalendrier;

    public function jsonSerialize()
    {
        $result = [];
        $result['codeDispense'] = $this->codeDispense;
        $result['dateDebut'] = json_encode($this->dateDebut);
        $result['dateFin'] = json_encode($this->dateFin);
        return $result;
    }

    /**
     * @return int
     */
    public function getCodeDispense()
    {
        return $this->codeDispense;
    }

    /**
     * @param int $codeDispense
     * @return Dispense
     */
    public function setCodeDispense($codeDispense)
    {
        $this->codeDispense = $codeDispense;
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
     * @return Dispense
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
     * @return Dispense
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * @return ModuleCalendrier
     */
    public function getModuleCalendrier()
    {
        return $this->moduleCalendrier;
    }

    /**
     * @param ModuleCalendrier $moduleCalendrier
     * @return Dispense
     */
    public function setModuleCalendrier($moduleCalendrier)
    {
        $this->moduleCalendrier = $moduleCalendrier;
        return $this;
    }

}

