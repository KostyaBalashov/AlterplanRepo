<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu
 *
 * @ORM\Table(name="Lieu")
 * @ORM\Entity
 */
class Lieu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codelieu;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=50, nullable=false)
     */
    private $libelle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true)
     */
    private $archive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="GestionEmargement", type="boolean", nullable=true)
     */
    private $gestionemargement;

    /**
     * @var string
     *
     * @ORM\Column(name="DebutAM", type="string", length=5, nullable=true)
     */
    private $debutam;

    /**
     * @var string
     *
     * @ORM\Column(name="FinAM", type="string", length=5, nullable=true)
     */
    private $finam;

    /**
     * @var string
     *
     * @ORM\Column(name="DebutPM", type="string", length=5, nullable=true)
     */
    private $debutpm;

    /**
     * @var string
     *
     * @ORM\Column(name="FinPM", type="string", length=5, nullable=true)
     */
    private $finpm;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=200, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="CP", type="integer", nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=100, nullable=true)
     */
    private $ville;


}

