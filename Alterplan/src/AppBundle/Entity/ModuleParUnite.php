<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleParUnite
 *
 * @ORM\Table(name="ModuleParUnite", indexes={@ORM\Index(name="IDX_53FF79899643ECE4", columns={"IdModule"}), @ORM\Index(name="IDX_53FF7989C51DBB99", columns={"IdUnite"})})
 * @ORM\Entity
 */
class ModuleParUnite
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
     * @var \AppBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")
     * })
     */
    private $idmodule;

    /**
     * @var \AppBundle\Entity\UniteParFormation
     *
     * @ORM\ManyToOne(targetEntity="UniteParFormation.php")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdUnite", referencedColumnName="Id")
     * })
     */
    private $idunite;


}

