<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="Entreprise")
 * @ORM\Entity
 */
class Entreprise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeEntreprise", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="RaisonSociale", type="string", length=255, nullable=false)
     */
    private $raisonsociale;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse1", type="string", length=500, nullable=true)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse2", type="string", length=500, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse3", type="string", length=500, nullable=true)
     */
    private $adresse3;

    /**
     * @var string
     *
     * @ORM\Column(name="CodePostal", type="string", length=5, nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=100, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=14, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="Fax", type="string", length=14, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="SiteWeb", type="string", length=100, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Observation", type="text", length=-1, nullable=true)
     */
    private $observation;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeTypeEntreprise", type="string", length=5, nullable=false)
     */
    private $codeTypeEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeRegion", type="string", length=2, nullable=false)
     */
    private $codeRegion;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeSecteur", type="integer", nullable=false)
     */
    private $codeSecteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrganisme", type="integer", nullable=true)
     */
    private $codeOrganisme;

    /**
     * @var string
     *
     * @ORM\Column(name="NomCommercial", type="string", length=255, nullable=true)
     */
    private $nomCommercial;

    /**
     * @var integer
     *
     * @ORM\Column(name="siret", type="integer", nullable=true)
     */
    private $siret;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeContactEni", type="integer", nullable=true)
     */
    private $codeContactEni;

    /**
     * @var integer
     *
     * @ORM\Column(name="CodeOrganismeFavoris", type="integer", nullable=true)
     */
    private $codeOrganismeFavoris;

    /**
     * @var stagiaireParEntreprise
     *
     * @ORM\OneToMany(targetEntity="StagiaireParEntreprise", mappedBy="entreprise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codeEntreprise", referencedColumnName="codeEntreprise")
     * })
     */
    private $stagiaireParEntreprise;

    /**
     * @return int
     */
    public function getCodeEntreprise()
    {
        return $this->codeEntreprise;
    }

    /**
     * @param int $codeEntreprise
     * @return Entreprise
     */
    public function setCodeEntreprise($codeEntreprise)
    {
        $this->codeEntreprise = $codeEntreprise;
        return $this;
    }

    /**
     * @return string
     */
    public function getRaisonsociale()
    {
        return $this->raisonsociale;
    }

    /**
     * @param string $raisonsociale
     * @return Entreprise
     */
    public function setRaisonsociale($raisonsociale)
    {
        $this->raisonsociale = $raisonsociale;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * @param string $adresse1
     * @return Entreprise
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * @param string $adresse2
     * @return Entreprise
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse3()
    {
        return $this->adresse3;
    }

    /**
     * @param string $adresse3
     * @return Entreprise
     */
    public function setAdresse3($adresse3)
    {
        $this->adresse3 = $adresse3;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param string $codePostal
     * @return Entreprise
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     * @return Entreprise
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return Entreprise
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     * @return Entreprise
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * @param string $siteWeb
     * @return Entreprise
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Entreprise
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param string $observation
     * @return Entreprise
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeTypeEntreprise()
    {
        return $this->codeTypeEntreprise;
    }

    /**
     * @param string $codeTypeEntreprise
     * @return Entreprise
     */
    public function setCodeTypeEntreprise($codeTypeEntreprise)
    {
        $this->codeTypeEntreprise = $codeTypeEntreprise;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeRegion()
    {
        return $this->codeRegion;
    }

    /**
     * @param string $codeRegion
     * @return Entreprise
     */
    public function setCodeRegion($codeRegion)
    {
        $this->codeRegion = $codeRegion;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeSecteur()
    {
        return $this->codeSecteur;
    }

    /**
     * @param int $codeSecteur
     * @return Entreprise
     */
    public function setCodeSecteur($codeSecteur)
    {
        $this->codeSecteur = $codeSecteur;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeOrganisme()
    {
        return $this->codeOrganisme;
    }

    /**
     * @param int $codeOrganisme
     * @return Entreprise
     */
    public function setCodeOrganisme($codeOrganisme)
    {
        $this->codeOrganisme = $codeOrganisme;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomCommercial()
    {
        return $this->nomCommercial;
    }

    /**
     * @param string $nomCommercial
     * @return Entreprise
     */
    public function setNomCommercial($nomCommercial)
    {
        $this->nomCommercial = $nomCommercial;
        return $this;
    }

    /**
     * @return int
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param int $siret
     * @return Entreprise
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeContactEni()
    {
        return $this->codeContactEni;
    }

    /**
     * @param int $codeContactEni
     * @return Entreprise
     */
    public function setCodeContactEni($codeContactEni)
    {
        $this->codeContactEni = $codeContactEni;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodeOrganismeFavoris()
    {
        return $this->codeOrganismeFavoris;
    }

    /**
     * @param int $codeOrganismeFavoris
     * @return Entreprise
     */
    public function setCodeOrganismeFavoris($codeOrganismeFavoris)
    {
        $this->codeOrganismeFavoris = $codeOrganismeFavoris;
        return $this;
    }

    /**
     * @return stagiaire
     */
    public function getStagiaireParEntreprise()
    {
        return $this->stagiaireParEntreprise;
    }

    /**
     * @param stagiaire $stagiaireParEntreprise
     */
    public function setStagiaireParEntreprise($stagiaireParEntreprise)
    {
        $this->stagiaireParEntreprise = $stagiaireParEntreprise;
    }

}

