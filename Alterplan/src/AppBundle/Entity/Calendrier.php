<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="Calendrier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalendrierRepository")
 */
class Calendrier
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="CodeCalendrier", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeCalendrier;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=100, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

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
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="integer", nullable=true)
     */
    private $dureeEnHeures;

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
     * @var \AppBundle\Entity\Stagiaire
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stagiaire", inversedBy="calendrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeStagiaire", referencedColumnName="CodeStagiaire")
     * })
     */
    private $stagiaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsInscrit", nullable=false, type="boolean")
     */
    private $isInscrit;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsModele", nullable=false, type="boolean" )
     */
    private $isModele;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Contrainte" , mappedBy="calendrier")
     */
    private $contraintes;

    public function __construct()
    {
        $this->contraintes = new ArrayCollection();
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
     * @return Calendrier
     */
    public function setDateDebut($dateDebut)
    {
        if(is_string($dateDebut))
            $this ->dateDebut = \DateTime::createFromFormat('Y/m/d', $dateDebut);
        else
            $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeCalendrier()
    {
        return $this->codeCalendrier;
    }

    /**
     * @param int $codeCalendrier
     * @return Calendrier
     */
    public function setCodeCalendrier($codeCalendrier)
    {
        $this->codeCalendrier = $codeCalendrier;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return Calendrier
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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
     * @return Calendrier
     */
    public function setDateCreation($dateCreation)
    {
        if(is_string($dateCreation))
            $this ->dateCreation = \DateTime::createFromFormat('Y/m/d', $dateCreation);
        else
            $this->dateCreation = $dateCreation;
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
     * @return Calendrier
     */
    public function setDateFin($dateFin)
    {
        if(is_string($dateFin))
            $this ->dateFin = \DateTime::createFromFormat('Y/m/d', $dateFin);
        else
            $this->dateFin = $dateFin;
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
     * @return Calendrier
     */
    public function setDureeEnHeures($dureeEnHeures)
    {
        $this->dureeEnHeures = $dureeEnHeures;
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
     * @return Calendrier
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
        return $this;
    }

    /**
     * @return Stagiaire
     */
    public function getStagiaire()
    {
        return $this->stagiaire;
    }

    /**
     * @param Stagiaire $stagiaire
     * @return Calendrier
     */
    public function setStagiaire($stagiaire)
    {
        $this->stagiaire = $stagiaire;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInscrit()
    {
        return $this->isInscrit;
    }

    /**
     * @param bool $isInscrit
     * @return Calendrier
     */
    public function setIsInscrit($isInscrit)
    {
        $this->isInscrit = $isInscrit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isModele()
    {
        return $this->isModele;
    }

    /**
     * @param bool $isModele
     * @return Calendrier
     */
    public function setIsModele($isModele)
    {
        $this->isModele = $isModele;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getContraintes()
    {
        return $this->contraintes;
    }

    /**
     * @param Collection $contraintes
     */
    public function setContraintes($contraintes)
    {
        $this->contraintes = $contraintes;
    }


}

