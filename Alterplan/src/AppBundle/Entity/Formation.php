<?php

namespace AppBundle\Entity;

use AppBundle\Utils\ArrayCollectionUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Formation
 *
 * @ORM\Table(name="Formation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationRepository")
 */
class Formation implements \JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="CodeFormation", type="string", length=8)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleLong", type="string", length=200, nullable=false)
     */
    private $libelleLong;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCourt", type="string", length=50, nullable=false)
     */
    private $libelleCourt;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="smallint", nullable=false)
     */
    private $dureeEnHeures;

    /**
     * @var float
     *
     * @ORM\Column(name="TauxHoraire", type="float", precision=53, scale=0, nullable=false)
     */
    private $tauxHoraire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTitre", type="string", length=8, nullable=true)
     */
    private $codeTitre;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPublicEnCours", type="float", precision=53, scale=0, nullable=false)
     */
    private $prixPublicEnCours;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeuresCentre", type="smallint", nullable=true)
     */
    private $heuresCentre;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeuresStage", type="smallint", nullable=true)
     */
    private $heuresStage;

    /**
     * @var integer
     *
     * @ORM\Column(name="SemainesCentre", type="smallint", nullable=true)
     */
    private $semainesCentre;

    /**
     * @var integer
     *
     * @ORM\Column(name="SemainesStage", type="smallint", nullable=true)
     */
    private $semainesStage;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnSemaines", type="smallint", nullable=false)
     */
    private $dureeEnSemaines;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Archiver", type="boolean", nullable=false)
     */
    private $archiver;

    /**
     * @var integer
     *
     * @ORM\Column(name="ECFaPasser", type="integer", nullable=true)
     */
    private $ecfApasser;

    /**
     * @var integer
     *
     * @ORM\Column(name="TypeFormation", type="integer", nullable=true)
     */
    private $typeFormation;

    /**
     * @var Lieu
     *
     * @ManyToOne(targetEntity="Lieu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeLieu", referencedColumnName="CodeLieu", nullable=true)
     * })
     */
    private $lieu;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UniteParFormation", mappedBy="formation")
     */
    private $unitesParFormation;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdreModule" , mappedBy="formation")
     */
    private $ordresModule;

    public function __construct()
    {
        $this->unitesParFormation = new ArrayCollection();
        $this->ordresModule = new ArrayCollection();
    }

    function jsonSerialize()
    {
        $result = array();

        $result['codeFormation'] = $this->codeFormation;
        $allModules = $this->getAllModules();

        $ordreModule = array();
        foreach ($allModules as $module){
            $ordreModule[$module->getIdModule()] = array();
            $modulesDisponibles = $this->getModulesDisponibles($module);
            $ordreModule[$module->getIdModule()]['modulesDisponibles'] = array();
            foreach ($modulesDisponibles as $moduleDispo){
                //$moduleDispo->getIdModule()
                $ordreModule[$module->getIdModule()]['modulesDisponibles'][] = $moduleDispo->jsonSerialize();
            }
            $ordre = $this->getOrdreModuleFromModule($module);
            if (!$ordre) {
                $ordre = new OrdreModule();
                $ordre->setModule($module);
            }
            $ordreModule[$module->getIdModule()]['ordreModule'] = $ordre->jsonSerialize();
        }
        $result['modules'] = $ordreModule;
        return $result;
    }

    public function getAllModules(){
        $modules = new  ArrayCollection();

        foreach ($this->getUnitesParFormation() as $uniteParFormation){
            foreach ($uniteParFormation->getModulesParUnite() as $moduleParUnite){
                if ($moduleParUnite && ($moduleParUnite->getModule())){
                    $modules->add($moduleParUnite->getModule());
                }
            }
        }

        return $modules;
    }

    /**
     * @return Collection
     */
    public function getOrdresModule()
    {
        return $this->ordresModule;
    }

    /**
     * @param Collection $ordresModule
     * @return Formation
     */
    public function setOrdresModule($ordresModule)
    {
        $this->ordresModule = $ordresModule;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUnitesParFormation()
    {
        return $this->unitesParFormation;
    }

    /**
     * @param Collection $unitesParFormation
     * @return Formation
     */
    public function setUnitesParFormation($unitesParFormation)
    {
        $this->unitesParFormation = $unitesParFormation;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeFormation()
    {
        return $this->codeFormation;
    }

    /**
     * @param string $codeFormation
     * @return Formation
     */
    public function setCodeFormation($codeFormation)
    {
        $this->codeFormation = $codeFormation;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleLong()
    {
        return $this->libelleLong;
    }

    /**
     * @param string $libelleLong
     * @return Formation
     */
    public function setLibelleLong($libelleLong)
    {
        $this->libelleLong = $libelleLong;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleCourt()
    {
        return $this->libelleCourt;
    }

    /**
     * @param string $libelleCourt
     * @return Formation
     */
    public function setLibelleCourt($libelleCourt)
    {
        $this->libelleCourt = $libelleCourt;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeEnHeures()
    {
        return $this->dureeEnHeures;
    }

    /**
     * @param int $dureeEnHeures
     * @return Formation
     */
    public function setDureeEnHeures($dureeEnHeures)
    {
        $this->dureeEnHeures = $dureeEnHeures;
        return $this;
    }

    /**
     * @return float
     */
    public function getTauxHoraire()
    {
        return $this->tauxHoraire;
    }

    /**
     * @param float $tauxHoraire
     * @return Formation
     */
    public function setTauxHoraire($tauxHoraire)
    {
        $this->tauxHoraire = $tauxHoraire;
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
     * @return Formation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeTitre()
    {
        return $this->codeTitre;
    }

    /**
     * @param string $codeTitre
     * @return Formation
     */
    public function setCodeTitre($codeTitre)
    {
        $this->codeTitre = $codeTitre;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrixPublicEnCours()
    {
        return $this->prixPublicEnCours;
    }

    /**
     * @param float $prixPublicEnCours
     * @return Formation
     */
    public function setPrixPublicEnCours($prixPublicEnCours)
    {
        $this->prixPublicEnCours = $prixPublicEnCours;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeuresCentre()
    {
        return $this->heuresCentre;
    }

    /**
     * @param int $heuresCentre
     * @return Formation
     */
    public function setHeuresCentre($heuresCentre)
    {
        $this->heuresCentre = $heuresCentre;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeuresStage()
    {
        return $this->heuresStage;
    }

    /**
     * @param int $heuresStage
     * @return Formation
     */
    public function setHeuresStage($heuresStage)
    {
        $this->heuresStage = $heuresStage;
        return $this;
    }

    /**
     * @return int
     */
    public function getSemainesCentre()
    {
        return $this->semainesCentre;
    }

    /**
     * @param int $semainesCentre
     * @return Formation
     */
    public function setSemainesCentre($semainesCentre)
    {
        $this->semainesCentre = $semainesCentre;
        return $this;
    }

    /**
     * @return int
     */
    public function getSemainesStage()
    {
        return $this->semainesStage;
    }

    /**
     * @param int $semainesStage
     * @return Formation
     */
    public function setSemainesStage($semainesStage)
    {
        $this->semainesStage = $semainesStage;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeEnSemaines()
    {
        return $this->dureeEnSemaines;
    }

    /**
     * @param int $dureeEnSemaines
     * @return Formation
     */
    public function setDureeEnSemaines($dureeEnSemaines)
    {
        $this->dureeEnSemaines = $dureeEnSemaines;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArchiver()
    {
        return $this->archiver;
    }

    /**
     * @param bool $archiver
     * @return Formation
     */
    public function setArchiver($archiver)
    {
        $this->archiver = $archiver;
        return $this;
    }

    /**
     * @return int
     */
    public function getEcfApasser()
    {
        return $this->ecfApasser;
    }

    /**
     * @param int $ecfApasser
     * @return Formation
     */
    public function setEcfApasser($ecfApasser)
    {
        $this->ecfApasser = $ecfApasser;
        return $this;
    }

    /**
     * @return int
     */
    public function getTypeFormation()
    {
        return $this->typeFormation;
    }

    /**
     * @param int $typeFormation
     * @return Formation
     */
    public function setTypeFormation($typeFormation)
    {
        $this->typeFormation = $typeFormation;
        return $this;
    }

    /**
     * @return Lieu
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param Lieu $lieu
     * @return Formation
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
        return $this;
    }

    private function getModulesDisponibles(Module $module){
        $modulesDisponibles = new ArrayCollection();
        $modulesFromOrdre = new ArrayCollection();
        $allModules = $this->getAllModules();
        $ordreModule = $this->getOrdreModuleFromModule($module);

        if ($ordreModule){
            $modulesFromOrdre->add($this->getModules($ordreModule));
        }
        $modulesFromOrdre->add($module);
        $modulesDisponibles = ArrayCollectionUtils::outerJoin($allModules, $modulesFromOrdre);
        return $modulesDisponibles;
    }

    private function getOrdreModuleFromModule(Module $module){
        if ($this->ordresModule){
            foreach ($this->ordresModule as $item){
                if ($item->getModule()->getIdModule() === $module->getIdModule()){
                    return $item;
                }
            }
        }
        return null;
    }

    private function getModules(OrdreModule $ordreModule){
        $modules = new  ArrayCollection();

        if ($ordreModule){
            foreach ($ordreModule->getGroupes() as $groupe){
                if ($groupe->getSousGroupe1())
                    $modules->add($this->getModulesFromSousGroupe($groupe->getSousGroupe1()));

                if ($groupe->getSousGroupe2())
                    $modules->add($this->getModulesFromSousGroupe($groupe->getSousGroupe2()));
            }
        }

        return $modules;
    }

    private function getModulesFromSousGroupe(SousGroupeModule $sousGroupe){
        $modules = new ArrayCollection();
        if ($sousGroupe){
            if ($sousGroupe->getModule1())
                $modules->add($sousGroupe->getModule1());
            if ($sousGroupe->getModule2())
                $modules->add($sousGroupe->getModule2());
            if ($sousGroupe->getModule3())
                $modules->add($sousGroupe->getModule3());
            if ($sousGroupe->getModule4())
                $modules->add($sousGroupe->getModule4());
        }
        return $modules;
    }
}

