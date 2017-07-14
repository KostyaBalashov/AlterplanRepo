<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UniteParFormation
 *
 * @ORM\Table(name="UniteParFormation", indexes={@ORM\Index(name="IDX_C1E36CE8A68ED5A2", columns={"CodeFormation"}), @ORM\Index(name="IDX_C1E36CE86837EF81", columns={"IdUniteFormation"})})
 * @ORM\Entity
 */
class UniteParFormation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="Position", type="smallint", nullable=false)
     */
    private $position;

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
     * @var \AppBundle\Entity\UniteFormation
     *
     * @ORM\ManyToOne(targetEntity="UniteFormation.php")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdUniteFormation", referencedColumnName="IdUniteFormation")
     * })
     */
    private $iduniteformation;


}

