<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="Module")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleRepository")
 */
class Module implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ModuleParUnite", mappedBy="module")
     */
    private $modulesParUnite;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Calendrier", mappedBy="modulesAPlanifier")
     */
    private $calendriersEnAttente;

    public function __construct()
    {
        $this->modulesParUnite = new ArrayCollection();
        $this->calendriersEnAttente = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        $result = array();
        $result['idModule'] = $this->idModule;
        $result['libelle'] = $this->libelle;
        if ($this->getFormation() != null) {
            $result['formation'] = ['CodeFormation' => $this->getFormation()->getCodeFormation(),
                'Libelle' => $this->getFormation()->getLibelleLong() . ' (' . $this->getFormation()->getLibelleCourt() . ')',
                'Lieu' => ($this->getFormation()->getLieu() != null ?
                    $this->getFormation()->getLieu()->getLibelle() : '-')];
        }
        return $result;
    }

    /**
     * @return Formation
     */
    public function getFormation()
    {
        $formation = null;

        foreach ($this->modulesParUnite as $item) {
            $uf = $item->getUniteParFormation();
            $f = ($uf != null ? $uf->getFormation() : null);

            if ($f) {
                if ($f->getAllModules()->contains($this)) {
                    $formation = $f;
                }
            }
        }

        return $formation;
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
     * @return Module
     */
    public function setCalendriersEnAttente($calendriersEnAttente)
    {
        $this->calendriersEnAttente = $calendriersEnAttente;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getModulesParUnite()
    {
        return $this->modulesParUnite;
    }

    /**
     * @param Collection $modulesParUnite
     * @return Module
     */
    public function setModulesParUnite($modulesParUnite)
    {
        $this->modulesParUnite = $modulesParUnite;
        return $this;
    }

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

