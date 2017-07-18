<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="Salle")
 * @ORM\Entity
 */
class Salle
{
    /**
     * @var string
     *
     * @ORM\Column(name="CodeSalle", type="string", length=5)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codeSalle;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle", type="string", length=50, nullable=false)
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="Capacite", type="integer", nullable=true)
     */
    private $capacite;

    /**
     * @var integer
     *
     * @ORM\Column(name="Lieu", type="integer", nullable=false)
     */
    private $lieu;

    /**
     * @return string
     */
    public function getCodeSalle()
    {
        return $this->codeSalle;
    }

    /**
     * @param string $codeSalle
     * @return Salle
     */
    public function setCodeSalle($codeSalle)
    {
        $this->codeSalle = $codeSalle;
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
     * @return Salle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return int
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * @param int $capacite
     * @return Salle
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;
        return $this;
    }

    /**
     * @return int
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param int $lieu
     * @return Salle
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
        return $this;
    }

}

