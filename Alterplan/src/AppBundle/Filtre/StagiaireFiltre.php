<?php
/**
 * Created by PhpStorm.
 * User: Ravet
 * Date: 06/08/2017
 * Time: 11:34
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Filtre;


class StagiaireFiltre
{

    /**
     * @var nom
     * Filtre sur le nom du stagiaire
     */
    private $nom;

    /**
     * @var prenom
     * Filtre sur le prénom du stagiaire
     */
    private $prenom;

    /**
     * @var email
     * Filtre sur l'email du stagiaire
     */
    private $email;

    /**
     * @var entreprise
     * Filtre sur la raison social de l'entreprise
     */
    private $entreprise;

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param mixed $entreprise
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;
    }
}