<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stagiaire
 *
 * @ORM\Table(name="Stagiaire")
 * @ORM\Entity
 */
class Stagiaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeStagiaire", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeStagiaire;

    /**
     * @var string
     *
     * @ORM\Column(name="Civilite", type="string", length=3, nullable=true)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse1", type="string", length=500, nullable=false)
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
     * @ORM\Column(name="Codepostal", type="string", length=5, nullable=true)
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
     * @ORM\Column(name="TelephoneFixe", type="string", length=14, nullable=true)
     */
    private $telephoneFixe;

    /**
     * @var string
     *
     * @ORM\Column(name="TelephonePortable", type="string", length=14, nullable=true)
     */
    private $telephonePortable;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateNaissance", type="datetime", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeRegion", type="string", length=2, nullable=true)
     */
    private $codeRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeNationalite", type="string", length=2, nullable=true)
     */
    private $codeNationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeOrigineMedia", type="string", length=3, nullable=true)
     */
    private $codeOrigineMedia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDernierEnvoiDoc", type="datetime", nullable=true)
     */
    private $dateDernierEnvoiDoc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="Repertoire", type="string", length=100, nullable=true)
     */
    private $repertoire;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Permis", type="boolean", nullable=false)
     */
    private $permis;

    /**
     * @var string
     *
     * @ORM\Column(name="Photo", type="string", length=100, nullable=true)
     */
    private $photo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="EnvoiDocEnCours", type="boolean", nullable=false)
     */
    private $envoiDocEnCours;

    /**
     * @var string
     *
     * @ORM\Column(name="Historique", type="text", length=-1, nullable=true)
     */
    private $historique;

    /**
     * @var stagiaire
     *
     * @ORM\OneToMany(targetEntity="Stagiaire", mappedBy="stagiaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CodeStagiaire", referencedColumnName="CodeStagiaire")
     * })
     */
    private $stagiaireParEntreprise;

    /**
     * @return int
     */
    public function getCodeStagiaire()
    {
        return $this->codeStagiaire;
    }

    /**
     * @param int $codeStagiaire
     * @return Stagiaire
     */
    public function setCodeStagiaire($codeStagiaire)
    {
        $this->codeStagiaire = $codeStagiaire;
        return $this;
    }

    /**
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     * @return Stagiaire
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Stagiaire
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return Stagiaire
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
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
     * @return Stagiaire
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
     * @return Stagiaire
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
     * @return Stagiaire
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
     * @return Stagiaire
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
     * @return Stagiaire
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephoneFixe()
    {
        return $this->telephoneFixe;
    }

    /**
     * @param string $telephoneFixe
     * @return Stagiaire
     */
    public function setTelephoneFixe($telephoneFixe)
    {
        $this->telephoneFixe = $telephoneFixe;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephonePortable()
    {
        return $this->telephonePortable;
    }

    /**
     * @param string $telephonePortable
     * @return Stagiaire
     */
    public function setTelephonePortable($telephonePortable)
    {
        $this->telephonePortable = $telephonePortable;
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
     * @return Stagiaire
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     * @return Stagiaire
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
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
     * @return Stagiaire
     */
    public function setCodeRegion($codeRegion)
    {
        $this->codeRegion = $codeRegion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeNationalite()
    {
        return $this->codeNationalite;
    }

    /**
     * @param string $codeNationalite
     * @return Stagiaire
     */
    public function setCodeNationalite($codeNationalite)
    {
        $this->codeNationalite = $codeNationalite;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeOrigineMedia()
    {
        return $this->codeOrigineMedia;
    }

    /**
     * @param string $codeOrigineMedia
     * @return Stagiaire
     */
    public function setCodeOrigineMedia($codeOrigineMedia)
    {
        $this->codeOrigineMedia = $codeOrigineMedia;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDernierEnvoiDoc()
    {
        return $this->dateDernierEnvoiDoc;
    }

    /**
     * @param \DateTime $dateDernierEnvoiDoc
     * @return Stagiaire
     */
    public function setDateDernierEnvoiDoc($dateDernierEnvoiDoc)
    {
        $this->dateDernierEnvoiDoc = $dateDernierEnvoiDoc;
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
     * @return Stagiaire
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepertoire()
    {
        return $this->repertoire;
    }

    /**
     * @param string $repertoire
     * @return Stagiaire
     */
    public function setRepertoire($repertoire)
    {
        $this->repertoire = $repertoire;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPermis()
    {
        return $this->permis;
    }

    /**
     * @param bool $permis
     * @return Stagiaire
     */
    public function setPermis($permis)
    {
        $this->permis = $permis;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     * @return Stagiaire
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnvoiDocEnCours()
    {
        return $this->envoiDocEnCours;
    }

    /**
     * @param bool $envoiDocEnCours
     * @return Stagiaire
     */
    public function setEnvoiDocEnCours($envoiDocEnCours)
    {
        $this->envoiDocEnCours = $envoiDocEnCours;
        return $this;
    }

    /**
     * @return string
     */
    public function getHistorique()
    {
        return $this->historique;
    }

    /**
     * @param string $historique
     * @return Stagiaire
     */
    public function setHistorique($historique)
    {
        $this->historique = $historique;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStagiaireParEntreprise()
    {
        return $this->stagiaireParEntreprise;
    }

    /**
     * @param mixed $stagiaireParEntreprise
     */
    public function setStagiaireParEntreprise($stagiaireParEntreprise)
    {
        $this->stagiaireParEntreprise = $stagiaireParEntreprise;
    }

}

