<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Data\Util\ArrayAccessibleResourceBundle;

/**
 * OrdreModule
 *
 * @ORM\Table(name="OrdreModule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdreModuleRepository")
 */
class OrdreModule implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrdreModule", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeOrdreModule;

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
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation", inversedBy="ordresModule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $formation;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GroupeModule", mappedBy="ordreModule")
     */
    private $groupes;

    public function __construct()
    {
        $this->groupes = new  ArrayCollection();
    }

    function jsonSerialize()
    {
        $result = array();
        $result['codeOrdreModule'] = $this->codeOrdreModule;
        $result['idModule'] = $this->module->getIdModule();
        $groupes = array();
        foreach ($this->groupes as $groupe){
            $groupes[] = $groupe->jsonSerialize();
        }
        $result['groupes'] = $groupes;
        return $result;
    }

    /**
     * @return Collection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * @param Collection $groupes
     * @return OrdreModule
     */
    public function setGroupes($groupes)
    {
        $this->groupes = $groupes;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeOrdreModule()
    {
        return $this->codeOrdreModule;
    }

    /**
     * @param int $codeOrdreModule
     * @return OrdreModule
     */
    public function setCodeOrdreModule($codeOrdreModule)
    {
        $this->codeOrdreModule = $codeOrdreModule;
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
     * @return OrdreModule
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * @param Formation $formation
     * @return OrdreModule
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
        return $this;
    }

}

