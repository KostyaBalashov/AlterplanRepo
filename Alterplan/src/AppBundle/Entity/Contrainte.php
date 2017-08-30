<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrainte
 *
 * @ORM\Table(name="Contrainte")
 * @ORM\Entity
 */
class Contrainte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContrainte", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeContrainte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

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
    private $typeP1;

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
    private $typeP2;

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
    private $typeP3;

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
    private $typeP4;

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
    private $typeP5;


    /**
     * @var \AppBundle\Entity\Calendrier
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendrier", inversedBy="contraintes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeCalendrier", referencedColumnName="CodeCalendrier")
     * })
     */
    private $calendrier;

    /**
     * @var \AppBundle\Entity\TypeContrainte
     *
     * @ORM\ManyToOne(targetEntity="TypeContrainte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeTypeContrainte", referencedColumnName="CodeTypeContrainte")
     * })
     */
    private $typeContrainte;

    /**
     * @return int
     */
    public function getCodeContrainte()
    {
        return $this->codeContrainte;
    }

    /**
     * @param int $codeContrainte
     * @return Contrainte
     */
    public function setCodeContrainte($codeContrainte)
    {
        $this->codeContrainte = $codeContrainte;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return Contrainte
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string
     */
    public function getP1()
    {
        return $this->p1;
    }

    /**
     * @param string $p1
     * @return Contrainte
     */
    public function setP1($p1)
    {
        $this->p1 = $p1;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeP1()
    {
        return $this->typeP1;
    }

    /**
     * @param string $typeP1
     * @return Contrainte
     */
    public function setTypeP1($typeP1)
    {
        $this->typeP1 = $typeP1;
        return $this;
    }

    /**
     * @return string
     */
    public function getP2()
    {
        return $this->p2;
    }

    /**
     * @param string $p2
     * @return Contrainte
     */
    public function setP2($p2)
    {
        $this->p2 = $p2;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeP2()
    {
        return $this->typeP2;
    }

    /**
     * @param string $typeP2
     * @return Contrainte
     */
    public function setTypeP2($typeP2)
    {
        $this->typeP2 = $typeP2;
        return $this;
    }

    /**
     * @return string
     */
    public function getP3()
    {
        return $this->p3;
    }

    /**
     * @param string $p3
     * @return Contrainte
     */
    public function setP3($p3)
    {
        $this->p3 = $p3;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeP3()
    {
        return $this->typeP3;
    }

    /**
     * @param string $typeP3
     * @return Contrainte
     */
    public function setTypeP3($typeP3)
    {
        $this->typeP3 = $typeP3;
        return $this;
    }

    /**
     * @return string
     */
    public function getP4()
    {
        return $this->p4;
    }

    /**
     * @param string $p4
     * @return Contrainte
     */
    public function setP4($p4)
    {
        $this->p4 = $p4;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeP4()
    {
        return $this->typeP4;
    }

    /**
     * @param string $typeP4
     * @return Contrainte
     */
    public function setTypeP4($typeP4)
    {
        $this->typeP4 = $typeP4;
        return $this;
    }

    /**
     * @return string
     */
    public function getP5()
    {
        return $this->p5;
    }

    /**
     * @param string $p5
     * @return Contrainte
     */
    public function setP5($p5)
    {
        $this->p5 = $p5;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeP5()
    {
        return $this->typeP5;
    }

    /**
     * @param string $typeP5
     * @return Contrainte
     */
    public function setTypeP5($typeP5)
    {
        $this->typeP5 = $typeP5;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeCalendrier()
    {
        return $this->codeCalendrier;
    }

    /**
     * @param int $codeCalendrier
     * @return Contrainte
     */
    public function setCodeCalendrier($codeCalendrier)
    {
        $this->codeCalendrier = $codeCalendrier;
        return $this;
    }

    /**
     * @return Calendrier
     */
    public function getCalendrier()
    {
        return $this->calendrier;
    }

    /**
     * @param Calendrier $calendrier
     * @return Contrainte
     */
    public function setCalendrier($calendrier)
    {
        $this->calendrier = $calendrier;
        return $this;
    }

    /**
     * @return TypeContrainte
     */
    public function getTypeContrainte()
    {
        return $this->typeContrainte;
    }

    /**
     * @param TypeContrainte $typeContrainte
     * @return Contrainte
     */
    public function setTypeContrainte($typeContrainte)
    {
        $this->typeContrainte = $typeContrainte;
        return $this;
    }
}

