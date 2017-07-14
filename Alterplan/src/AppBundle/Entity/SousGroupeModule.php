<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousGroupeModule
 *
 * @ORM\Table(name="SousGroupeModule")
 * @ORM\Entity
 */
class SousGroupeModule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSousGroupeModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeSousGroupeModule;

    /**
     * @var string
     *
     * @ORM\Column(name="Module1", type="string", length=45, nullable=true)
     */
    private $module1;

    /**
     * @var string
     *
     * @ORM\Column(name="Module2", type="string", length=45, nullable=true)
     */
    private $module2;

    /**
     * @var string
     *
     * @ORM\Column(name="Module3", type="string", length=45, nullable=true)
     */
    private $module3;

    /**
     * @var string
     *
     * @ORM\Column(name="Module4", type="string", length=45, nullable=true)
     */
    private $module4;

    /**
     * @var \AppBundle\Entity\Module
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")
     * })
     */
    private $module;

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

    /**
     * @return string
     */
    public function getModule1()
    {
        return $this->module1;
    }

    /**
     * @param string $module1
     * @return SousGroupeModule
     */
    public function setModule1($module1)
    {
        $this->module1 = $module1;
        return $this;
    }

    /**
     * @return string
     */
    public function getModule2()
    {
        return $this->module2;
    }

    /**
     * @param string $module2
     * @return SousGroupeModule
     */
    public function setModule2($module2)
    {
        $this->module2 = $module2;
        return $this;
    }

    /**
     * @return string
     */
    public function getModule3()
    {
        return $this->module3;
    }

    /**
     * @param string $module3
     * @return SousGroupeModule
     */
    public function setModule3($module3)
    {
        $this->module3 = $module3;
        return $this;
    }

    /**
     * @return string
     */
    public function getModule4()
    {
        return $this->module4;
    }

    /**
     * @param string $module4
     * @return SousGroupeModule
     */
    public function setModule4($module4)
    {
        $this->module4 = $module4;
        return $this;
    }

    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param Module $module
     * @return SousGroupeModule
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

}

