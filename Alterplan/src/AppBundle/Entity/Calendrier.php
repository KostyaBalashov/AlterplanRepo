<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="Calendrier", indexes={@ORM\Index(name="IDX_FD283F69A68ED5A2", columns={"CodeFormation"}), @ORM\Index(name="IDX_FD283F69A9AC032C", columns={"CodeStagiaire"})})
 * @ORM\Entity
 */
class Calendrier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeCalendrier", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stagiaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeStagiaire", referencedColumnName="CodeStagiaire")
     * })
     */
    private $stagiaire;

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


}

