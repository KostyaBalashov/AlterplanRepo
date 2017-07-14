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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numlien;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeStagiaire", type="integer", nullable=false)
     */
    private $codestagiaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeEntreprise", type="integer", nullable=false)
     */
    private $codeentreprise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateLien", type="datetime", nullable=false)
     */
    private $datelien;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTypeLien", type="string", length=5, nullable=false)
     */
    private $codetypelien;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebutEnEts", type="datetime", nullable=true)
     */
    private $datedebutenets;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFinEnEts", type="datetime", nullable=true)
     */
    private $datefinenets;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeFonction", type="string", length=5, nullable=true)
     */
    private $codefonction;

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
    private $codetuteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="ResponsableEts", type="integer", nullable=true)
     */
    private $responsableets;

    /**
     * @var integer
     *
     * @ORM\Column(name="GererPar", type="integer", nullable=true)
     */
    private $gererpar;

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
    private $sujetstage;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreVise", type="string", length=5, nullable=true)
     */
    private $titrevise;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContactEni", type="integer", nullable=true)
     */
    private $codecontacteni;


}

