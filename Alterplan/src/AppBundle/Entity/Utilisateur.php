<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User;

/**
 * Utilisateur
 *
 * @ORM\Table(name="Utilisateur")
 * @ORM\Entity
 */
class Utilisateur extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeUtilisateur", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=100, nullable=true)
     */
    private $prenom;

    /**
     * @var binary
     *
     * @ORM\Column(name="IsAdministrateur", type="binary", nullable=false)
     */
    private $isAdministrateur;

    /**
     * @var string
     *
     * @ORM\Column(name="MotDePasse", type="string", nullable=false)
     */
    private $motDePasse;

    /**
     * @return int
     */
    public function getCodeUtilisateur()
    {
        return $this->codeUtilisateur;
    }

    /**
     * @param int $codeUtilisateur
     * @return Utilisateur
     */
    public function setCodeUtilisateur($codeUtilisateur)
    {
        $this->codeUtilisateur = $codeUtilisateur;
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
     * @return Utilisateur
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
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return parent::getEmail();
    }

    /**
     * @param string $email
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        return $this;
    }

    /**
     * @return binary
     */
    public function getisAdministrateur()
    {
        return $this->isAdministrateur;
    }

    /**
     * @param binary $isAdministrateur
     * @return Utilisateur
     */
    public function setIsAdministrateur($isAdministrateur)
    {
        $this->isAdministrateur = $isAdministrateur;
        return $this;
    }

    /**
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param string $motDePasse
     * @return Utilisateur
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

}

