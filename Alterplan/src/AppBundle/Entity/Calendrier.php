<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Table(name="Calendrier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalendrierRepository")
 */
class Calendrier
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="CodeCalendrier", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeCalendrier;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=100, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var integer
     *
     * @ORM\Column(name="DureeEnHeures", type="integer", nullable=true)
     */
    private $dureeEnHeures;

    /**
     * @var \AppBundle\Entity\Formation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeFormation", referencedColumnName="CodeFormation")
     * })
     */
    private $formation;

    /**
     * @var \AppBundle\Entity\Stagiaire
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stagiaire", inversedBy="calendrier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeStagiaire", referencedColumnName="CodeStagiaire")
     * })
     */
    private $stagiaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsInscrit", nullable=false, type="boolean")
     */
    private $isInscrit;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsModele", nullable=false, type="boolean" )
     */
    private $isModele;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Contrainte" , mappedBy="calendrier", cascade={"persist", "remove" })
     */
    private $contraintes;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ModuleCalendrier", mappedBy="calendrier", cascade={"persist", "remove" })
     */
    private $modulesCalendrier;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Module", inversedBy="calendriersEnAttente")
     * @ORM\JoinTable(name="ModuleAPlanifier",
     *     joinColumns={@ORM\JoinColumn(name="CodeCalendrier", referencedColumnName="CodeCalendrier")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="IdModule", referencedColumnName="IdModule")})
     */
    private $modulesAPlanifier;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ModuleCalendrier", inversedBy="calendriersEnAttente")
     * @ORM\JoinTable(name="ModuleCalendrierAPlacer",
     *     joinColumns={@ORM\JoinColumn(name="CodeCalendrier", referencedColumnName="CodeCalendrier")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="CodeModuleCalendrier", referencedColumnName="CodeModuleCalendrier")})
     */
    private $modulesCalendrierAPlacer;

    public function __construct()
    {
        $this->contraintes = new ArrayCollection();
        $this->modulesCalendrier = new ArrayCollection();
        $this->modulesAPlanifier = new ArrayCollection();
        $this->modulesCalendrierAPlacer = new ArrayCollection();
    }

    /**
     * Ajoute un module à la liste des modules à placer.
     * @param Module $module module à placer.
     */
    public function addModuleAPlacer(Module $module)
    {
        if (!$this->modulesAPlanifier->contains($module)) {
            $module->getCalendriersEnAttente()->add($this);
            $this->modulesAPlanifier->add($module);
        }
    }

    /**
     * Supprime un module de la liste des modules à placer.
     * @param Module $module
     */
    public function removeModuleAPlacer(Module $module)
    {
        if ($this->modulesAPlanifier->contains($module)) {
            $this->modulesCalendrierAPlacer->removeElement($module);
            $module->getCalendriersEnAttente()->removeElement($this);
        }
    }

    /**
     * Ajoute une semaine d'un module à la liste des semaine à placer.
     * @param ModuleCalendrier $moduleCalendrier semaine d'un module.
     */
    public function addModuleCalendrierAPlacer(ModuleCalendrier $moduleCalendrier)
    {
        if (!$this->modulesCalendrierAPlacer->contains($moduleCalendrier)) {
            $this->modulesCalendrierAPlacer->add($moduleCalendrier);
            $moduleCalendrier->getCalendriersEnAttente()->add($this);
        }
    }

    /**
     * Supprime une semaine de la liste des semaines à placer.
     * @param ModuleCalendrier $moduleCalendrier semaine à supprimer.
     */
    public function removeModuleCalendrierAPlacer(ModuleCalendrier $moduleCalendrier)
    {
        if ($this->modulesCalendrierAPlacer->contains($moduleCalendrier)) {
            $this->modulesCalendrierAPlacer->removeElement($moduleCalendrier);
            $moduleCalendrier->getCalendriersEnAttente()->removeElement($this);
        }
    }

    /**
     * Ajoute une semaine d'un module à laliste des semaines planifiées.
     * @param ModuleCalendrier $moduleCalendrier semaine à ajouter.
     */
    public function addModuleCalendrier(ModuleCalendrier $moduleCalendrier)
    {
        $moduleCalendrier->setCalendrier($this);
        if (!$this->modulesCalendrier->contains($moduleCalendrier)) {
            $this->modulesCalendrier->add($moduleCalendrier);
        }
    }

    /**
     * Supprime une semaine de la liste des semaines planifiées.
     * @param ModuleCalendrier $moduleCalendrier semaine à supprimer.
     */
    public function removeModuleCalendrier(ModuleCalendrier $moduleCalendrier)
    {
        $moduleCalendrier->setCalendrier(null);
        if ($this->modulesCalendrier->contains($moduleCalendrier)) {
            $this->modulesCalendrier->removeElement($moduleCalendrier);
        }
    }

    /**
     * @return Collection
     */
    public function getModulesAPlanifier()
    {
        return $this->modulesAPlanifier;
    }

    /**
     * @param Collection $modulesAPlanifier
     * @return Calendrier
     */
    public function setModulesAPlanifier($modulesAPlanifier)
    {
        $this->modulesAPlanifier = $modulesAPlanifier;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getModulesCalendrierAPlacer()
    {
        return $this->modulesCalendrierAPlacer;
    }

    /**
     * @param Collection $modulesCalendrierAPlacer
     * @return Calendrier
     */
    public function setModulesCalendrierAPlacer($modulesCalendrierAPlacer)
    {
        $this->modulesCalendrierAPlacer = $modulesCalendrierAPlacer;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     * @return Calendrier
     */
    public function setDateDebut($dateDebut)
    {
        if (is_string($dateDebut))
            $this->dateDebut = \DateTime::createFromFormat('Y/m/d', $dateDebut);
        else
            $this->dateDebut = $dateDebut;
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
     * @return Calendrier
     */
    public function setCodeCalendrier($codeCalendrier)
    {
        $this->codeCalendrier = $codeCalendrier;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return Calendrier
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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
     * @return Calendrier
     */
    public function setDateCreation($dateCreation)
    {
        if (is_string($dateCreation))
            $this->dateCreation = \DateTime::createFromFormat('Y/m/d', $dateCreation);
        else
            $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     * @return Calendrier
     */
    public function setDateFin($dateFin)
    {
        if (is_string($dateFin))
            $this->dateFin = \DateTime::createFromFormat('Y/m/d', $dateFin);
        else
            $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeEnHeures()
    {
        if (sizeof($this->modulesCalendrier) > 0) {

            $result = 0;
            foreach ($this->modulesCalendrier as $value) {
                $result += $value->getNombreHeuresReel();
            }

            return $result;
        }

        return $this->dureeEnHeures;
    }

    /**
     * @param int $dureeEnHeures
     * @return Calendrier
     */
    public function setDureeEnHeures($dureeEnHeures)
    {
        $this->dureeEnHeures = $dureeEnHeures;
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
     * @return Calendrier
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;
        return $this;
    }

    /**
     * @return Stagiaire
     */
    public function getStagiaire()
    {
        return $this->stagiaire;
    }

    /**
     * @param Stagiaire $stagiaire
     * @return Calendrier
     */
    public function setStagiaire($stagiaire)
    {
        $this->stagiaire = $stagiaire;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInscrit()
    {
        return $this->isInscrit;
    }

    /**
     * @param bool $isInscrit
     * @return Calendrier
     */
    public function setIsInscrit($isInscrit)
    {
        $this->isInscrit = $isInscrit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isModele()
    {
        return $this->isModele;
    }

    /**
     * @param bool $isModele
     * @return Calendrier
     */
    public function setIsModele($isModele)
    {
        $this->isModele = $isModele;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getContraintes()
    {
        return $this->contraintes;
    }

    /**
     * @param Collection $contraintes
     */
    public function setContraintes($contraintes)
    {
        $this->contraintes = $contraintes;
    }

    /**
     * @return Collection
     */
    public function getModulesCalendrier()
    {
        return $this->modulesCalendrier;
    }

    /**
     * @param Collection $modulesCalendrier
     * @return Calendrier
     */
    public function setModulesCalendrier($modulesCalendrier)
    {
        $this->modulesCalendrier = $modulesCalendrier;
        return $this;
    }

    /**
     * On Surcharge la fonction clone pour cloner toute la grappe du calendrier.
     * Contraintes - moduleCalendrier
     */
    public function __clone()
    {
        if ($this->codeCalendrier) {
            // On crée une nouvelle liste de clone de moduleCalendrier
            $listModuleCalendrierClone = new ArrayCollection();

            // On parcourt la liste des moduleCalendrier de ce calendrier
            foreach ($this->modulesCalendrier as $moduleCalendrier) {
                $moduleCalendrierClone = clone $moduleCalendrier;

                // Pour chaque module de ce calendrier, on le clone
                $moduleCalendrierClone->setCalendrier($this);
                $listModuleCalendrierClone->add($moduleCalendrierClone);

                // On crée une nouvelle liste de clone de contrainte
                $listContrainteClone = new ArrayCollection();

                // On parcourt la liste des contraintes de ce calendrier
                foreach ($this->contraintes as $contrainte) {

                    // Pour chaque contrainte de ce calendrier, on le clone
                    // et on l'ajoute à la nouvelle liste des contraintes
                    $contrainteClone = clone $contrainte;
                    $contrainteClone->setCalendrier($this);
                    $listContrainteClone->add($contrainteClone);
                }

                // On met à jour la liste de moduleCalendrier et contraintes de ce calendrier avec les nouvelles
                // Cela va permettre de cloner les données lié au calendrier à cloner pour les lier et les persister
                // au nouveau calendrier
                $this->setContraintes($listContrainteClone);

                $this->setModulesCalendrier($listModuleCalendrierClone);
            }
        }
    }
}

