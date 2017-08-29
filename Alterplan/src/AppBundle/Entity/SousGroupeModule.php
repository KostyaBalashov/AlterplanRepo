<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SousGroupeModule
 *
 * @ORM\Table(name="SousGroupeModule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SousGroupeModuleRepository")
 */
class SousGroupeModule implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupeModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeSousGroupeModule;

    /**
     * @var GroupeModule
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GroupeModule", inversedBy="sousGroupes")
     * @ORM\JoinColumn(name="CodeGroupeModule", referencedColumnName="CodeGroupeModule")
     */
    private $groupe;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Module", fetch="EAGER")
     * @ORM\JoinTable(name="AssocitionModuleSousGroupeModule",
     *     joinColumns={@ORM\JoinColumn(name="CodeSousGroupeModule", referencedColumnName="CodeSousGroupeModule")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")})
     */
    private $modules;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        $result = array();
        $result['codeSousGroupe'] = $this->codeSousGroupeModule;
        $modules = array();

        foreach ($this->modules as $module){
            $modules[$module->getIdModule()] = $module->jsonSerialize();
        }

        $result['modules'] = $modules;
        return $result;
    }

    /**
     * @return GroupeModule
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * @param GroupeModule $groupe
     * @return SousGroupeModule
     */
    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @param ArrayCollection $modules
     * @return SousGroupeModule
     */
    public function setModules($modules)
    {
        $this->modules = $modules;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeSousGroupeModule()
    {
        return $this->codeSousGroupeModule;
    }

    /**
     * @param int $codeSousGroupeModule
     * @return SousGroupeModule
     */
    public function setCodeSousGroupeModule($codeSousGroupeModule)
    {
        $this->codeSousGroupeModule = $codeSousGroupeModule;
        return $this;
    }
}

