<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupeModule
 *
 * @ORM\Table(name="GroupeModule")
 * @ORM\Entity
 */
class GroupeModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeGroupeModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeGroupeModule;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupe1", type="integer", nullable=true)
     */
    private $codeSousGroupe1;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupe2", type="integer", nullable=true)
     */
    private $codeSousGroupe2;

    /**
     * @var \AppBundle\Entity\OrdreModule
     *
     * @ORM\ManyToOne(targetEntity="OrdreModule", inversedBy="groupes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeOrdreModule", referencedColumnName="CodeOrdreModule")
     * })
     */
    private $ordreModule;

    /**
     * @var SousGroupeModule
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SousGroupeModule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeSousGroupe1", referencedColumnName="CodeSousGroupeModule")
     * })
     */
    private $sousGroupe1;

    /**
     * @var SousGroupeModule
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SousGroupeModule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeSousGroupe2", referencedColumnName="CodeSousGroupeModule")
     * })
     */
    private $sousGroupe2;

    /**
     * @return SousGroupeModule
     */
    public function getSousGroupe1()
    {
        return $this->sousGroupe1;
    }

    /**
     * @param SousGroupeModule $sousGroupe1
     * @return GroupeModule
     */
    public function setSousGroupe1($sousGroupe1)
    {
        $this->sousGroupe1 = $sousGroupe1;
        return $this;
    }

    /**
     * @return SousGroupeModule
     */
    public function getSousGroupe2()
    {
        return $this->sousGroupe2;
    }

    /**
     * @param SousGroupeModule $sousGroupe2
     * @return GroupeModule
     */
    public function setSousGroupe2($sousGroupe2)
    {
        $this->sousGroupe2 = $sousGroupe2;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeGroupeModule()
    {
        return $this->codeGroupeModule;
    }

    /**
     * @param int $codeGroupeModule
     * @return GroupeModule
     */
    public function setCodeGroupeModule($codeGroupeModule)
    {
        $this->codeGroupeModule = $codeGroupeModule;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeSousGroupe1()
    {
        return $this->codeSousGroupe1;
    }

    /**
     * @param int $codeSousGroupe1
     * @return GroupeModule
     */
    public function setCodeSousGroupe1($codeSousGroupe1)
    {
        $this->codeSousGroupe1 = $codeSousGroupe1;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeSousGroupe2()
    {
        return $this->codeSousGroupe2;
    }

    /**
     * @param int $codeSousGroupe2
     * @return GroupeModule
     */
    public function setCodeSousGroupe2($codeSousGroupe2)
    {
        $this->codeSousGroupe2 = $codeSousGroupe2;
        return $this;
    }

    /**
     * @return OrdreModule
     */
    public function getOrdreModule()
    {
        return $this->ordreModule;
    }

    /**
     * @param OrdreModule $ordreModule
     * @return GroupeModule
     */
    public function setOrdreModule($ordreModule)
    {
        $this->ordreModule = $ordreModule;
        return $this;
    }
}

