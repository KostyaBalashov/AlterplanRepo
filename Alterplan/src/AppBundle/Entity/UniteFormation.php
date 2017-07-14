<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UniteFormation
 *
 * @ORM\Table(name="UniteFormation")
 * @ORM\Entity
 */
class UniteFormation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdUniteFormation", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUniteFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=200, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="smallint", nullable=false)
     */
    private $dureeEnHeures;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnSemaines", type="smallint", nullable=false)
     */
    private $dureeEnSemaines;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCourt", type="string", length=10, nullable=false)
     */
    private $libelleCourt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Archiver", type="boolean", nullable=false)
     */
    private $archiver;

    /**
     * @return int
     */
    public function getIdUniteFormation()
    {
        return $this->idUniteFormation;
    }

    /**
     * @param int $idUniteFormation
     * @return UniteFormation
     */
    public function setIdUniteFormation($idUniteFormation)
    {
        $this->idUniteFormation = $idUniteFormation;
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
     * @return UniteFormation
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeEnHeures()
    {
        return $this->dureeEnHeures;
    }

    /**
     * @param int $dureeEnHeures
     * @return UniteFormation
     */
    public function setDureeEnHeures($dureeEnHeures)
    {
        $this->dureeEnHeures = $dureeEnHeures;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return UniteFormation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeEnSemaines()
    {
        return $this->dureeEnSemaines;
    }

    /**
     * @param int $dureeEnSemaines
     * @return UniteFormation
     */
    public function setDureeEnSemaines($dureeEnSemaines)
    {
        $this->dureeEnSemaines = $dureeEnSemaines;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleCourt()
    {
        return $this->libelleCourt;
    }

    /**
     * @param string $libelleCourt
     * @return UniteFormation
     */
    public function setLibelleCourt($libelleCourt)
    {
        $this->libelleCourt = $libelleCourt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArchiver()
    {
        return $this->archiver;
    }

    /**
     * @param bool $archiver
     * @return UniteFormation
     */
    public function setArchiver($archiver)
    {
        $this->archiver = $archiver;
        return $this;
    }

}

