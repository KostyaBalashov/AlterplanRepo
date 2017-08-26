<?php

namespace AppBundle\Entity;

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
     * @var Module
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Module", fetch="EAGER")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="Module1", referencedColumnName="IdModule")
     * })
     */
    private $module1;

    /**
     * @var Module
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Module", fetch="EAGER")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="Module2", referencedColumnName="IdModule")
     * })
     */
    private $module2;

    /**
     * @var Module
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Module", fetch="EAGER")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="Module3", referencedColumnName="IdModule")
     * })
     */
    private $module3;

    /**
     * @var Module
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Module", fetch="EAGER")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="Module4", referencedColumnName="IdModule")
     * })
     */
    private $module4;

    public function jsonSerialize()
    {
        $result = array();
        $result['codeSousGroupe'] = $this->codeSousGroupeModule;
        $modules = array();
        if ($this->module1){
            $modules[] = $this->module1->jsonSerialize();
        }
        if ($this->module2){
            $modules[] = $this->module2->jsonSerialize();
        }
        if ($this->module3){
            $modules[] = $this->module3->jsonSerialize();
        }
        if ($this->module4){
            $modules[] = $this->module4->jsonSerialize();
        }
        $result['modules'] = $modules;
        return $result;
    }

    /**
     * @return Module
     */
    public function getModule1()
    {
        return $this->module1;
    }

    /**
     * @param Module $module1
     * @return SousGroupeModule
     */
    public function setModule1($module1)
    {
        $this->module1 = $module1;
        return $this;
    }

    /**
     * @return Module
     */
    public function getModule2()
    {
        return $this->module2;
    }

    /**
     * @param Module $module2
     * @return SousGroupeModule
     */
    public function setModule2($module2)
    {
        $this->module2 = $module2;
        return $this;
    }

    /**
     * @return Module
     */
    public function getModule3()
    {
        return $this->module3;
    }

    /**
     * @param Module $module3
     * @return SousGroupeModule
     */
    public function setModule3($module3)
    {
        $this->module3 = $module3;
        return $this;
    }

    /**
     * @return Module
     */
    public function getModule4()
    {
        return $this->module4;
    }

    /**
     * @param Module $module4
     * @return SousGroupeModule
     */
    public function setModule4($module4)
    {
        $this->module4 = $module4;
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

