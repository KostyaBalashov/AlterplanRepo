<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdreModule
 *
 * @ORM\Table(name="OrdreModule", indexes={@ORM\Index(name="IDX_50B5AEDA9643ECE4", columns={"IdModule"}), @ORM\Index(name="IDX_50B5AEDAA68ED5A2", columns={"CodeFormation"})})
 * @ORM\Entity
 */
class OrdreModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrdreModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeordremodule;

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
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $codeformation;


}

