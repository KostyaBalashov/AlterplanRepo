<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu
 *
 * @ORM\Table(name="Lieu")
 * @ORM\Entity
 */
class Lieu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeLieu", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeLieu;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=50, nullable=false)
     */
    private $libelle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true)
     */
    private $archive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="GestionEmargement", type="boolean", nullable=true)
     */
    private $gestionEmargement;

    /**
     * @var string
     *
     * @ORM\Column(name="DebutAM", type="string", length=5, nullable=true)
     */
    private $debutAM;

    /**
     * @var string
     *
     * @ORM\Column(name="FinAM", type="string", length=5, nullable=true)
     */
    private $finAM;

    /**
     * @var string
     *
     * @ORM\Column(name="DebutPM", type="string", length=5, nullable=true)
     */
    private $debutPM;

    /**
     * @var string
     *
     * @ORM\Column(name="FinPM", type="string", length=5, nullable=true)
     */
    private $finPM;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=200, nullable=true)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="CP", type="integer", nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=100, nullable=true)
     */
    private $ville;

    /**
     * @return int
     */


    public function getCodeLieu()
    {
        return $this->codeLieu;
    }

    /**
     * @param int $codeLieu
     * @return Lieu
     */
    public function setCodeLieu($codeLieu)
    {
        $this->codeLieu = $codeLieu;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     * @return Lieu
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArchive()
    {
        return $this->archive;
    }

    /**
     * @param bool $archive
     * @return Lieu
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGestionEmargement()
    {
        return $this->gestionEmargement;
    }

    /**
     * @param bool $gestionEmargement
     * @return Lieu
     */
    public function setGestionEmargement($gestionEmargement)
    {
        $this->gestionEmargement = $gestionEmargement;
        return $this;
    }

    /**
     * @return string
     */
    public function getDebutAM()
    {
        return $this->debutAM;
    }

    /**
     * @param string $debutAM
     * @return Lieu
     */
    public function setDebutAM($debutAM)
    {
        $this->debutAM = $debutAM;
        return $this;
    }

    /**
     * @return string
     */
    public function getFinAM()
    {
        return $this->finAM;
    }

    /**
     * @param string $finAM
     * @return Lieu
     */
    public function setFinAM($finAM)
    {
        $this->finAM = $finAM;
        return $this;
    }

    /**
     * @return string
     */
    public function getDebutPM()
    {
        return $this->debutPM;
    }

    /**
     * @param string $debutPM
     * @return Lieu
     */
    public function setDebutPM($debutPM)
    {
        $this->debutPM = $debutPM;
        return $this;
    }

    /**
     * @return string
     */
    public function getFinPM()
    {
        return $this->finPM;
    }

    /**
     * @param string $finPM
     * @return Lieu
     */
    public function setFinPM($finPM)
    {
        $this->finPM = $finPM;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     * @return Lieu
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param int $cp
     * @return Lieu
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
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
     * @return Lieu
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }
}

