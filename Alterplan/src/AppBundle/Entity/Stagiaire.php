<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stagiaire
 *
 * @ORM\Table(name="Stagiaire")
 * @ORM\Entity
 */
class Stagiaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeStagiaire", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codestagiaire;

    /**
     * @var string
     *
     * @ORM\Column(name="Civilite", type="string", length=3, nullable=true)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse1", type="string", length=500, nullable=false)
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
     * @ORM\Column(name="Codepostal", type="string", length=5, nullable=true)
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
     * @ORM\Column(name="TelephoneFixe", type="string", length=14, nullable=true)
     */
    private $telephonefixe;

    /**
     * @var string
     *
     * @ORM\Column(name="TelephonePortable", type="string", length=14, nullable=true)
     */
    private $telephoneportable;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateNaissance", type="datetime", nullable=true)
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeRegion", type="string", length=2, nullable=true)
     */
    private $coderegion;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeNationalite", type="string", length=2, nullable=true)
     */
    private $codenationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeOrigineMedia", type="string", length=3, nullable=true)
     */
    private $codeoriginemedia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDernierEnvoiDoc", type="datetime", nullable=true)
     */
    private $datedernierenvoidoc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=true)
     */
    private $datecreation;

    /**
     * @var string
     *
     * @ORM\Column(name="Repertoire", type="string", length=100, nullable=true)
     */
    private $repertoire;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Permis", type="boolean", nullable=false)
     */
    private $permis;

    /**
     * @var string
     *
     * @ORM\Column(name="Photo", type="string", length=100, nullable=true)
     */
    private $photo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="EnvoiDocEnCours", type="boolean", nullable=false)
     */
    private $envoidocencours;

    /**
     * @var string
     *
     * @ORM\Column(name="Historique", type="text", length=-1, nullable=true)
     */
    private $historique;


}

