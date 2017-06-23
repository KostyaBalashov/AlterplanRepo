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
 * @package UtilisateurBundle\Entite
 *
 * @ORM\Entity
 * @ORM\Table(name="Utilisateur")
 */
class Utilisateur extends User
{

}