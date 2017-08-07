<?php
/**
 * Created by PhpStorm.
 * User: a590697
 * Date: 06/08/2017
 * Time: 15:30
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;


use AppBundle\Filtre\StagiaireFiltre;

class StagiaireRepository
{
    /**
     * @param StagiaireFiltre|null $filter
     * @return mixed
     */
    public function search(StagiaireFiltre $filter = null){
        //Si le filtre n'est pas null
        if ($filter !== null){
            //On retourne le résultat
            return $this->findAll();
        }else{
            //S'il n'y a pas de filtre on retourne tous les enregistrements
            return $this->findAll();
        }
    }
}