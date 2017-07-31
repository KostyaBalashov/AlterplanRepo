<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 31/07/2017
 * Time: 17:34
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Filtre;

/**
 * Class UtilisateurFiltre représente les critères de filtre sur les utilisateurs.
 * @package AppBundle\Filtre
 */
class UtilisateurFiltre
{
    /**
     * @var string
     * Filtre sur le nom
     */
    private $nom;

    /**
     * @var string
     * Filtre sur le prénom
     */
    private $prenom;

    /**
     * @var string
     * Filtre sur le login
     */
    private $identifiant;

    /**
     * @var bool
     * Filtre sur le type d'utilisateur
     */
    private $isAdministrateur;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return UtilisateurFiltre
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
     * @return UtilisateurFiltre
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * @param string $identifiant
     * @return UtilisateurFiltre
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdministrateur()
    {
        return $this->isAdministrateur;
    }

    /**
     * @param bool $isAdministrateur
     * @return UtilisateurFiltre
     */
    public function setIsAdministrateur($isAdministrateur)
    {
        $this->isAdministrateur = $isAdministrateur;
        return $this;
    }
}