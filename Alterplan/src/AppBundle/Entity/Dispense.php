<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dispense
 *
 * @ORM\Table(name="Dispense", indexes={@ORM\Index(name="IDX_D5C4DB11C7EE6FE3", columns={"CodeModuleCalendrier"})})
 * @ORM\Entity
 */
class Dispense
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeDispense", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codedispense;

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
     * @var \AppBundle\Entity\ModuleCalendrier
     *
     * @ORM\ManyToOne(targetEntity="ModuleCalendrier.php")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeModuleCalendrier", referencedColumnName="CodeModuleCalendrier")
     * })
     */
    private $codemodulecalendrier;


}

