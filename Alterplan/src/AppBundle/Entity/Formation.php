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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeformation;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleLong", type="string", length=200, nullable=false)
     */
    private $libellelong;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCourt", type="string", length=50, nullable=false)
     */
    private $libellecourt;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="smallint", nullable=false)
     */
    private $dureeenheures;

    /**
     * @var float
     *
     * @ORM\Column(name="TauxHoraire", type="float", precision=53, scale=0, nullable=false)
     */
    private $tauxhoraire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTitre", type="string", length=8, nullable=true)
     */
    private $codetitre;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPublicEnCours", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixpublicencours;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeuresCentre", type="smallint", nullable=true)
     */
    private $heurescentre;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeuresStage", type="smallint", nullable=true)
     */
    private $heuresstage;

    /**
     * @var integer
     *
     * @ORM\Column(name="SemainesCentre", type="smallint", nullable=true)
     */
    private $semainescentre;

    /**
     * @var integer
     *
     * @ORM\Column(name="SemainesStage", type="smallint", nullable=true)
     */
    private $semainesstage;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnSemaines", type="smallint", nullable=false)
     */
    private $dureeensemaines;

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
    private $ecfapasser;

    /**
     * @var integer
     *
     * @ORM\Column(name="TypeFormation", type="integer", nullable=true)
     */
    private $typeformation;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer", nullable=true)
     */
    private $codelieu;


}

