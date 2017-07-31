<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 31/07/2017
 * Time: 19:09
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;


use AppBundle\Filtre\UtilisateurFiltre;
use Doctrine\ORM\EntityRepository;

class UtilisateurRepository extends EntityRepository
{
    public  function search(UtilisateurFiltre $filter = null){
        if ($filter !== null){
            $query = $this->createQueryBuilder('u');
            if ($filter->getPrenom() !== null && trim($filter->getPrenom()) !== ''){
                $query->andWhere('u.prenom LIKE :prenom')->setParameter('prenom', $filter->getPrenom());
            }
            if ($filter->getNom() !== null && trim($filter->getNom()) !== ''){
                $query->andWhere('u.nom LIKE :nom')->setParameter('nom', $filter->getNom());
            }
            if ($filter->getIdentifiant() != null && trim($filter->getIdentifiant()) !== ''){
                $query->andWhere('u.username LIKE :login')->setParameter('login', $filter->getIdentifiant());
            }
            return $query->getQuery()->getResult();
        }else{
            return $this->findAll();
        }
    }
}