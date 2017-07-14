<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="Cours", indexes={@ORM\Index(name="IDX_3C0BA3989643ECE4", columns={"IdModule"}), @ORM\Index(name="IDX_3C0BA39827D389CC", columns={"CodePromotion"})})
 * @ORM\Entity
 */
class Cours
{
    /**
     * @var guid
     *
     * @ORM\Column(name="IdCours", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Debut", type="datetime", nullable=false)
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fin", type="datetime", nullable=false)
     */
    private $fin;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeReelleEnHeures", type="smallint", nullable=false)
     */
    private $dureeReelleEnHeures;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPublicAffecte", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixPublicAffecte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCours", type="string", length=50, nullable=false)
     */
    private $libelleCours;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureePrevueEnHeures", type="smallint", nullable=false)
     */
    private $dureePrevueEnHeures;

    /**
     * @var boolean
     *
     * @ORM\Column(name="DateAdefinir", type="boolean", nullable=false)
     */
    private $dateAdefinir;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeSalle", type="string", length=5, nullable=true)
     */
    private $codeSalle;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeFormateur", type="integer", nullable=true)
     */
    private $codeFormateur;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer", nullable=true)
     */
    private $codeLieu;

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
     * @var \AppBundle\Entity\Promotion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Promotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodePromotion", referencedColumnName="CodePromotion")
     * })
     */
    private $promotion;

    /**
     * @return guid
     */
    public function getIdCours()
    {
        return $this->idCours;
    }

    /**
     * @param guid $idCours
     * @return Cours
     */
    public function setIdCours($idCours)
    {
        $this->idCours = $idCours;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * @param \DateTime $debut
     * @return Cours
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * @param \DateTime $fin
     * @return Cours
     */
    public function setFin($fin)
    {
        $this->fin = $fin;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeReelleEnHeures()
    {
        return $this->dureeReelleEnHeures;
    }

    /**
     * @param int $dureeReelleEnHeures
     * @return Cours
     */
    public function setDureeReelleEnHeures($dureeReelleEnHeures)
    {
        $this->dureeReelleEnHeures = $dureeReelleEnHeures;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrixPublicAffecte()
    {
        return $this->prixPublicAffecte;
    }

    /**
     * @param float $prixPublicAffecte
     * @return Cours
     */
    public function setPrixPublicAffecte($prixPublicAffecte)
    {
        $this->prixPublicAffecte = $prixPublicAffecte;
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
     * @return Cours
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleCours()
    {
        return $this->libelleCours;
    }

    /**
     * @param string $libelleCours
     * @return Cours
     */
    public function setLibelleCours($libelleCours)
    {
        $this->libelleCours = $libelleCours;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureePrevueEnHeures()
    {
        return $this->dureePrevueEnHeures;
    }

    /**
     * @param int $dureePrevueEnHeures
     * @return Cours
     */
    public function setDureePrevueEnHeures($dureePrevueEnHeures)
    {
        $this->dureePrevueEnHeures = $dureePrevueEnHeures;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDateAdefinir()
    {
        return $this->dateAdefinir;
    }

    /**
     * @param bool $dateAdefinir
     * @return Cours
     */
    public function setDateAdefinir($dateAdefinir)
    {
        $this->dateAdefinir = $dateAdefinir;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeSalle()
    {
        return $this->codeSalle;
    }

    /**
     * @param string $codeSalle
     * @return Cours
     */
    public function setCodeSalle($codeSalle)
    {
        $this->codeSalle = $codeSalle;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeFormateur()
    {
        return $this->codeFormateur;
    }

    /**
     * @param int $codeFormateur
     * @return Cours
     */
    public function setCodeFormateur($codeFormateur)
    {
        $this->codeFormateur = $codeFormateur;
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
     * @return Cours
     */
    public function setCodeLieu($codeLieu)
    {
        $this->codeLieu = $codeLieu;
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
     * @return Cours
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param Promotion $promotion
     * @return Cours
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
        return $this;
    }
}

