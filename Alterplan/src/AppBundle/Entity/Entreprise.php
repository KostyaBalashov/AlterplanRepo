<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="Entreprise")
 * @ORM\Entity
 */
class Entreprise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeEntreprise", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeentreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="RaisonSociale", type="string", length=255, nullable=false)
     */
    private $raisonsociale;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse1", type="string", length=500, nullable=true)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse2", type="string", length=500, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse3", type="string", length=500, nullable=true)
     */
    private $adresse3;

    /**
     * @var string
     *
     * @ORM\Column(name="CodePostal", type="string", length=5, nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=100, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=14, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="Fax", type="string", length=14, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="SiteWeb", type="string", length=100, nullable=true)
     */
    private $siteweb;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Observation", type="text", length=-1, nullable=true)
     */
    private $observation;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTypeEntreprise", type="string", length=5, nullable=false)
     */
    private $codetypeentreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeRegion", type="string", length=2, nullable=false)
     */
    private $coderegion;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSecteur", type="integer", nullable=false)
     */
    private $codesecteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrganisme", type="integer", nullable=true)
     */
    private $codeorganisme;

    /**
     * @var string
     *
     * @ORM\Column(name="NomCommercial", type="string", length=255, nullable=true)
     */
    private $nomcommercial;

    /**
     * @var integer
     *
     * @ORM\Column(name="siret", type="integer", nullable=true)
     */
    private $siret;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContactEni", type="integer", nullable=true)
     */
    private $codecontacteni;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrganismeFavoris", type="integer", nullable=true)
     */
    private $codeorganismefavoris;


}

