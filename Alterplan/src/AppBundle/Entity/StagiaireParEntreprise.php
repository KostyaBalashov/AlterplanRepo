<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StagiaireParEntreprise
 *
 * @ORM\Table(name="StagiaireParEntreprise")
 * @ORM\Entity
 */
class StagiaireParEntreprise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="NumLien", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $numLien;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeStagiaire", type="integer", nullable=false)
     */
    private $codeStagiaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeEntreprise", type="integer", nullable=false)
     */
    private $codeEntreprise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateLien", type="datetime", nullable=false)
     */
    private $dateLien;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTypeLien", type="string", length=5, nullable=false)
     */
    private $codeTypeLien;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebutEnEts", type="datetime", nullable=true)
     */
    private $dateDebutEnEts;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFinEnEts", type="datetime", nullable=true)
     */
    private $dateFinEnEts;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeFonction", type="string", length=5, nullable=true)
     */
    private $codeFonction;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=0, nullable=true)
     */
    private $commentaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeTuteur", type="integer", nullable=true)
     */
    private $codeTuteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="ResponsableEts", type="integer", nullable=true)
     */
    private $responsableEts;

    /**
     * @var integer
     *
     * @ORM\Column(name="GererPar", type="integer", nullable=true)
     */
    private $gererPar;

    /**
     * @var integer
     *
     * @ORM\Column(name="Interruption", type="integer", nullable=true)
     */
    private $interruption;

    /**
     * @var string
     *
     * @ORM\Column(name="SujetStage", type="text", length=-1, nullable=true)
     */
    private $sujetStage;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreVise", type="string", length=5, nullable=true)
     */
    private $titreVise;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContactEni", type="integer", nullable=true)
     */
    private $codeContactEni;

    /**
     * @return int
     */
    public function getNumLien()
    {
        return $this->numLien;
    }

    /**
     * @param int $numLien
     * @return StagiaireParEntreprise
     */
    public function setNumLien($numLien)
    {
        $this->numLien = $numLien;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeStagiaire()
    {
        return $this->codeStagiaire;
    }

    /**
     * @param int $codeStagiaire
     * @return StagiaireParEntreprise
     */
    public function setCodeStagiaire($codeStagiaire)
    {
        $this->codeStagiaire = $codeStagiaire;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeEntreprise()
    {
        return $this->codeEntreprise;
    }

    /**
     * @param int $codeEntreprise
     * @return StagiaireParEntreprise
     */
    public function setCodeEntreprise($codeEntreprise)
    {
        $this->codeEntreprise = $codeEntreprise;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateLien()
    {
        return $this->dateLien;
    }

    /**
     * @param \DateTime $dateLien
     * @return StagiaireParEntreprise
     */
    public function setDateLien($dateLien)
    {
        $this->dateLien = $dateLien;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeTypeLien()
    {
        return $this->codeTypeLien;
    }

    /**
     * @param string $codeTypeLien
     * @return StagiaireParEntreprise
     */
    public function setCodeTypeLien($codeTypeLien)
    {
        $this->codeTypeLien = $codeTypeLien;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebutEnEts()
    {
        return $this->dateDebutEnEts;
    }

    /**
     * @param \DateTime $dateDebutEnEts
     * @return StagiaireParEntreprise
     */
    public function setDateDebutEnEts($dateDebutEnEts)
    {
        $this->dateDebutEnEts = $dateDebutEnEts;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFinEnEts()
    {
        return $this->dateFinEnEts;
    }

    /**
     * @param \DateTime $dateFinEnEts
     * @return StagiaireParEntreprise
     */
    public function setDateFinEnEts($dateFinEnEts)
    {
        $this->dateFinEnEts = $dateFinEnEts;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeFonction()
    {
        return $this->codeFonction;
    }

    /**
     * @param string $codeFonction
     * @return StagiaireParEntreprise
     */
    public function setCodeFonction($codeFonction)
    {
        $this->codeFonction = $codeFonction;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     * @return StagiaireParEntreprise
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeTuteur()
    {
        return $this->codeTuteur;
    }

    /**
     * @param int $codeTuteur
     * @return StagiaireParEntreprise
     */
    public function setCodeTuteur($codeTuteur)
    {
        $this->codeTuteur = $codeTuteur;
        return $this;
    }

    /**
     * @return int
     */
    public function getResponsableEts()
    {
        return $this->responsableEts;
    }

    /**
     * @param int $responsableEts
     * @return StagiaireParEntreprise
     */
    public function setResponsableEts($responsableEts)
    {
        $this->responsableEts = $responsableEts;
        return $this;
    }

    /**
     * @return int
     */
    public function getGererPar()
    {
        return $this->gererPar;
    }

    /**
     * @param int $gererPar
     * @return StagiaireParEntreprise
     */
    public function setGererPar($gererPar)
    {
        $this->gererPar = $gererPar;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterruption()
    {
        return $this->interruption;
    }

    /**
     * @param int $interruption
     * @return StagiaireParEntreprise
     */
    public function setInterruption($interruption)
    {
        $this->interruption = $interruption;
        return $this;
    }

    /**
     * @return string
     */
    public function getSujetStage()
    {
        return $this->sujetStage;
    }

    /**
     * @param string $sujetStage
     * @return StagiaireParEntreprise
     */
    public function setSujetStage($sujetStage)
    {
        $this->sujetStage = $sujetStage;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitreVise()
    {
        return $this->titreVise;
    }

    /**
     * @param string $titreVise
     * @return StagiaireParEntreprise
     */
    public function setTitreVise($titreVise)
    {
        $this->titreVise = $titreVise;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeContactEni()
    {
        return $this->codeContactEni;
    }

    /**
     * @param int $codeContactEni
     * @return StagiaireParEntreprise
     */
    public function setCodeContactEni($codeContactEni)
    {
        $this->codeContactEni = $codeContactEni;
        return $this;
    }

}

