<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="Module")
 * @ORM\Entity
 */
class Module
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idModule;

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
     * @var float
     *
     * @ORM\Column(name="PrixPublicEnCours", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixPublicEnCours;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCourt", type="string", length=20, nullable=false)
     */
    private $libelleCourt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Archiver", type="boolean", nullable=false)
     */
    private $archiver;

    /**
     * @var integer
     *
     * @ORM\Column(name="TypeModule", type="integer", nullable=true)
     */
    private $typeModule;

    /**
     * @return int
     */
    public function getIdModule()
    {
        return $this->idModule;
    }

    /**
     * @param int $idModule
     * @return Module
     */
    public function setIdModule($idModule)
    {
        $this->idModule = $idModule;
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
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * @return Module
     */
    public function setDureeEnSemaines($dureeEnSemaines)
    {
        $this->dureeEnSemaines = $dureeEnSemaines;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrixPublicEnCours()
    {
        return $this->prixPublicEnCours;
    }

    /**
     * @param float $prixPublicEnCours
     * @return Module
     */
    public function setPrixPublicEnCours($prixPublicEnCours)
    {
        $this->prixPublicEnCours = $prixPublicEnCours;
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
     * @return Module
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
     * @return Module
     */
    public function setArchiver($archiver)
    {
        $this->archiver = $archiver;
        return $this;
    }

    /**
     * @return int
     */
    public function getTypeModule()
    {
        return $this->typeModule;
    }

    /**
     * @param int $typeModule
     * @return Module
     */
    public function setTypeModule($typeModule)
    {
        $this->typeModule = $typeModule;
        return $this;
    }

}

