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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeTypeContrainte;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=250, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="NbParametres", type="integer", nullable=true)
     */
    private $nbParametres;

    /**
     * @return int
     */
    public function getCodeTypeContrainte()
    {
        return $this->codeTypeContrainte;
    }

    /**
     * @param int $codeTypeContrainte
     * @return TypeContrainte
     */
    public function setCodeTypeContrainte($codeTypeContrainte)
    {
        $this->codeTypeContrainte = $codeTypeContrainte;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     * @return TypeContrainte
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbParametres()
    {
        return $this->nbParametres;
    }

    /**
     * @param int $nbParametres
     * @return TypeContrainte
     */
    public function setNbParametres($nbParametres)
    {
        $this->nbParametres = $nbParametres;
        return $this;
    }

}

