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
     * @ORM\ManyToOne(targetEntity="OrdreModule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeOrdreModule", referencedColumnName="CodeOrdreModule")
     * })
     */
    private $ordreModule;

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

