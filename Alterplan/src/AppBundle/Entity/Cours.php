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
    private $idcours;

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
    private $dureereelleenheures;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPublicAffecte", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixpublicaffecte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCours", type="string", length=50, nullable=false)
     */
    private $libellecours;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureePrevueEnHeures", type="smallint", nullable=false)
     */
    private $dureeprevueenheures;

    /**
     * @var boolean
     *
     * @ORM\Column(name="DateAdefinir", type="boolean", nullable=false)
     */
    private $dateadefinir;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeSalle", type="string", length=5, nullable=true)
     */
    private $codesalle;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeFormateur", type="integer", nullable=true)
     */
    private $codeformateur;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer", nullable=true)
     */
    private $codelieu;

    /**
     * @var \AppBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")
     * })
     */
    private $idmodule;

    /**
     * @var \AppBundle\Entity\Promotion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Promotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodePromotion", referencedColumnName="CodePromotion")
     * })
     */
    private $codepromotion;


}

