<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupeModule
 *
 * @ORM\Table(name="GroupeModule", indexes={@ORM\Index(name="IDX_CC2CDA2A93959DDA", columns={"CodeOrdreModule"})})
 * @ORM\Entity
 */
class GroupeModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeGroupeModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codegroupemodule;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupe1", type="integer", nullable=true)
     */
    private $codesousgroupe1;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupe2", type="integer", nullable=true)
     */
    private $codesousgroupe2;

    /**
     * @var \AppBundle\Entity\OrdreModule
     *
     * @ORM\ManyToOne(targetEntity="OrdreModule.php")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeOrdreModule", referencedColumnName="CodeOrdreModule")
     * })
     */
    private $codeordremodule;


}

