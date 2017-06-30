<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 23/06/2017
 * Time: 15:43
 */

namespace UtilisateurBundle\Entite;


use FOS\UserBundle\Model\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Utilisateur
 * @package UtilisateurBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Utilisateur")
 */
class Utilisateur extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CodeUtilisateur", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="Nom", type="string", length=100, nullable=true)
     */
    protected $nom;

    /**
     * @var string
     * @ORM\Column(name="Prenom", type="string", length=100, nullable=true)
     */
    protected $prenom;

    /**
     * @var string
     * @ORM\Column(name="Email", type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(name="MotDePasse", type="string")
     */
    protected $password;

    /**
     * @var boolean
     * @ORM\Column(name="IsAdministrateur", type="boolean")
     */
    protected $isAdministrateur;
}