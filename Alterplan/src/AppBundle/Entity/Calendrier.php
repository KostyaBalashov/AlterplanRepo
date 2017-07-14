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
    private $codecalendrier;

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
    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="datetime", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=true)
     */
    private $datefin;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="integer", nullable=true)
     */
    private $dureeenheures;

    /**
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $codeformation;

    /**
     * @var \AppBundle\Entity\Stagiaire
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stagiaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeStagiaire", referencedColumnName="CodeStagiaire")
     * })
     */
    private $codestagiaire;


}

