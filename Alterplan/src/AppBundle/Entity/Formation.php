<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="Formation")
 * @ORM\Entity
 */
class Formation
{
    /**
     * @var string
     *
     * @ORM\Column(name="CodeFormation", type="string", length=8)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleLong", type="string", length=200, nullable=false)
     */
    private $libelleLong;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCourt", type="string", length=50, nullable=false)
     */
    private $libelleCourt;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="smallint", nullable=false)
     */
    private $dureeEnHeures;

    /**
     * @var float
     *
     * @ORM\Column(name="TauxHoraire", type="float", precision=53, scale=0, nullable=false)
     */
    private $tauxHoraire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTitre", type="string", length=8, nullable=true)
     */
    private $codeTitre;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPublicEnCours", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixPublicEnCours;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeuresCentre", type="smallint", nullable=true)
     */
    private $heuresCentre;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeuresStage", type="smallint", nullable=true)
     */
    private $heuresStage;

    /**
     * @var integer
     *
     * @ORM\Column(name="SemainesCentre", type="smallint", nullable=true)
     */
    private $semainesCentre;

    /**
     * @var integer
     *
     * @ORM\Column(name="SemainesStage", type="smallint", nullable=true)
     */
    private $semainesStage;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnSemaines", type="smallint", nullable=false)
     */
    private $dureeEnSemaines;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Archiver", type="boolean", nullable=false)
     */
    private $archiver;

    /**
     * @var integer
     *
     * @ORM\Column(name="ECFaPasser", type="integer", nullable=true)
     */
    private $ecfApasser;

    /**
     * @var integer
     *
     * @ORM\Column(name="TypeFormation", type="integer", nullable=true)
     */
    private $typeFormation;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer", nullable=true)
     */
    private $codeLieu;

    /**
     * @return string
     */
    public function getCodeFormation()
    {
        return $this->codeFormation;
    }

    /**
     * @param string $codeFormation
     * @return Formation
     */
    public function setCodeFormation($codeFormation)
    {
        $this->codeFormation = $codeFormation;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleLong()
    {
        return $this->libelleLong;
    }

    /**
     * @param string $libelleLong
     * @return Formation
     */
    public function setLibelleLong($libelleLong)
    {
        $this->libelleLong = $libelleLong;
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
     * @return Formation
     */
    public function setLibelleCourt($libelleCourt)
    {
        $this->libelleCourt = $libelleCourt;
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
     * @return Formation
     */
    public function setDureeEnHeures($dureeEnHeures)
    {
        $this->dureeEnHeures = $dureeEnHeures;
        return $this;
    }

    /**
     * @return float
     */
    public function getTauxHoraire()
    {
        return $this->tauxHoraire;
    }

    /**
     * @param float $tauxHoraire
     * @return Formation
     */
    public function setTauxHoraire($tauxHoraire)
    {
        $this->tauxHoraire = $tauxHoraire;
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
     * @return Formation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeTitre()
    {
        return $this->codeTitre;
    }

    /**
     * @param string $codeTitre
     * @return Formation
     */
    public function setCodeTitre($codeTitre)
    {
        $this->codeTitre = $codeTitre;
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
     * @return Formation
     */
    public function setPrixPublicEnCours($prixPublicEnCours)
    {
        $this->prixPublicEnCours = $prixPublicEnCours;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeuresCentre()
    {
        return $this->heuresCentre;
    }

    /**
     * @param int $heuresCentre
     * @return Formation
     */
    public function setHeuresCentre($heuresCentre)
    {
        $this->heuresCentre = $heuresCentre;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeuresStage()
    {
        return $this->heuresStage;
    }

    /**
     * @param int $heuresStage
     * @return Formation
     */
    public function setHeuresStage($heuresStage)
    {
        $this->heuresStage = $heuresStage;
        return $this;
    }

    /**
     * @return int
     */
    public function getSemainesCentre()
    {
        return $this->semainesCentre;
    }

    /**
     * @param int $semainesCentre
     * @return Formation
     */
    public function setSemainesCentre($semainesCentre)
    {
        $this->semainesCentre = $semainesCentre;
        return $this;
    }

    /**
     * @return int
     */
    public function getSemainesStage()
    {
        return $this->semainesStage;
    }

    /**
     * @param int $semainesStage
     * @return Formation
     */
    public function setSemainesStage($semainesStage)
    {
        $this->semainesStage = $semainesStage;
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
     * @return Formation
     */
    public function setDureeEnSemaines($dureeEnSemaines)
    {
        $this->dureeEnSemaines = $dureeEnSemaines;
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
     * @return Formation
     */
    public function setArchiver($archiver)
    {
        $this->archiver = $archiver;
        return $this;
    }

    /**
     * @return int
     */
    public function getEcfApasser()
    {
        return $this->ecfApasser;
    }

    /**
     * @param int $ecfApasser
     * @return Formation
     */
    public function setEcfApasser($ecfApasser)
    {
        $this->ecfApasser = $ecfApasser;
        return $this;
    }

    /**
     * @return int
     */
    public function getTypeFormation()
    {
        return $this->typeFormation;
    }

    /**
     * @param int $typeFormation
     * @return Formation
     */
    public function setTypeFormation($typeFormation)
    {
        $this->typeFormation = $typeFormation;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeLieu()
    {
        return $this->codeLieu;
    }

    /**
     * @param int $codeLieu
     * @return Formation
     */
    public function setCodeLieu($codeLieu)
    {
        $this->codeLieu = $codeLieu;
        return $this;
    }
}

