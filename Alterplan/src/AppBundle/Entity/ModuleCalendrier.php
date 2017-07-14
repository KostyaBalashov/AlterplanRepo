<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleCalendrier
 *
 * @ORM\Table(name="ModuleCalendrier", indexes={@ORM\Index(name="IDX_FDEAFAC19643ECE4", columns={"IdModule"}), @ORM\Index(name="IDX_FDEAFAC1D1959E94", columns={"CodeCalendrier"})})
 * @ORM\Entity
 */
class ModuleCalendrier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeModuleCalendrier", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codemodulecalendrier;

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
     * @var \AppBundle\Entity\Calendrier
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeCalendrier", referencedColumnName="CodeCalendrier")
     * })
     */
    private $codecalendrier;


}

