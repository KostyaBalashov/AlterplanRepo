<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrainte
 *
 * @ORM\Table(name="Contrainte", indexes={@ORM\Index(name="IDX_58CF59A0F7BD16B7", columns={"Calendrier_CodeCalendrier"}), @ORM\Index(name="IDX_58CF59A0A3F4844E", columns={"CodeTypeContrainte"})})
 * @ORM\Entity
 */
class Contrainte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContrainte", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codecontrainte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCréation", type="datetime", nullable=false)
     */
    private $datecr�ation;

    /**
     * @var string
     *
     * @ORM\Column(name="P1", type="string", length=250, nullable=true)
     */
    private $p1;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeP1", type="string", length=250, nullable=true)
     */
    private $typep1;

    /**
     * @var string
     *
     * @ORM\Column(name="P2", type="string", length=250, nullable=true)
     */
    private $p2;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeP2", type="string", length=250, nullable=true)
     */
    private $typep2;

    /**
     * @var string
     *
     * @ORM\Column(name="P3", type="string", length=250, nullable=true)
     */
    private $p3;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeP3", type="string", length=250, nullable=true)
     */
    private $typep3;

    /**
     * @var string
     *
     * @ORM\Column(name="P4", type="string", length=250, nullable=true)
     */
    private $p4;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeP4", type="string", length=250, nullable=true)
     */
    private $typep4;

    /**
     * @var string
     *
     * @ORM\Column(name="P5", type="string", length=250, nullable=true)
     */
    private $p5;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeP5", type="string", length=250, nullable=true)
     */
    private $typep5;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeCalendrier", type="integer", nullable=false)
     */
    private $codecalendrier;

    /**
     * @var \AppBundle\Entity\Calendrier
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Calendrier_CodeCalendrier", referencedColumnName="CodeCalendrier")
     * })
     */
    private $calendrierCodecalendrier;

    /**
     * @var \AppBundle\Entity\TypeContrainte
     *
     * @ORM\ManyToOne(targetEntity="TypeContrainte.php")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeTypeContrainte", referencedColumnName="CodeTypeContrainte")
     * })
     */
    private $codetypecontrainte;


}

