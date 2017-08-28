<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupeModule
 *
 * @ORM\Table(name="GroupeModule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupeModuleRepository")
 */
class GroupeModule implements \JsonSerializable
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SousGroupeModule", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeSousGroupe1", referencedColumnName="CodeSousGroupeModule")
     * })
     */
    private $sousGroupe1;

    /**
     * @var SousGroupeModule
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SousGroupeModule", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeSousGroupe2", referencedColumnName="CodeSousGroupeModule")
     * })
     */
    private $sousGroupe2;

    function jsonSerialize()
    {
        $result = array();
        $result['codeGroupe'] = $this->codeGroupeModule;
        $sousGroupes = array();
        if ($this->sousGroupe1){
            $sousGroupes[$this->sousGroupe1->getCodeSousGroupeModule()] = $this->sousGroupe1->jsonSerialize();
        }
        if ($this->sousGroupe2){
            $sousGroupes[$this->sousGroupe2->getCodeSousGroupeModule()] = $this->sousGroupe2->jsonSerialize();
        }
        $result['sousGroupes'] = $sousGroupes;
        return $result;
    }

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

