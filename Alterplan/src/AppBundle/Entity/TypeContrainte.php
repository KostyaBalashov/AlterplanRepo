<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeContrainte
 *
 * @ORM\Table(name="TypeContrainte")
 * @ORM\Entity
 */
class TypeContrainte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeTypeContrainte", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codetypecontrainte;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=250, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="NbParamèrtres", type="integer", nullable=true)
     */
    private $nbparam�rtres;


}

