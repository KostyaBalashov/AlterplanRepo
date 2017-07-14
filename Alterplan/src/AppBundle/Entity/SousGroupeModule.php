<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousGroupeModule
 *
 * @ORM\Table(name="SousGroupeModule", indexes={@ORM\Index(name="IDX_C597609A9643ECE4", columns={"IdModule"})})
 * @ORM\Entity
 */
class SousGroupeModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupeModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codesousgroupemodule;

    /**
     * @var string
     *
     * @ORM\Column(name="Module1", type="string", length=45, nullable=true)
     */
    private $module1;

    /**
     * @var string
     *
     * @ORM\Column(name="Module2", type="string", length=45, nullable=true)
     */
    private $module2;

    /**
     * @var string
     *
     * @ORM\Column(name="Module3", type="string", length=45, nullable=true)
     */
    private $module3;

    /**
     * @var string
     *
     * @ORM\Column(name="Module4", type="string", length=45, nullable=true)
     */
    private $module4;

    /**
     * @var \AppBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")
     * })
     */
    private $idmodule;


}

