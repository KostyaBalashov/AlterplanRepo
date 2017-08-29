<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SousGroupeModule", mappedBy="groupe", fetch="EAGER")
     */
    private $sousGroupes;

    public function __construct()
    {
        $this->sousGroupes = new ArrayCollection();
    }

    function jsonSerialize()
    {
        $result = array();
        $result['codeGroupe'] = $this->codeGroupeModule;
        $sousGroupes = array();

        foreach ($this->sousGroupes as $sousGroupe){
            $sousGroupes[$sousGroupe->getCodeSousGroupeModule()] = $sousGroupe->jsonSerialize();
        }

        $result['sousGroupes'] = $sousGroupes;
        return $result;
    }

    /**
     * @return ArrayCollection
     */
    public function getSousGroupes()
    {
        return $this->sousGroupes;
    }

    /**
     * @param ArrayCollection $sousGroupes
     * @return GroupeModule
     */
    public function setSousGroupes($sousGroupes)
    {
        $this->sousGroupes = $sousGroupes;
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

