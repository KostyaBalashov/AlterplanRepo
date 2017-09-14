<?php
/**
 * Created by PhpStorm.
 * User: penno
 * Date: 01/08/2017
 * Time: 20:34
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;

use AppBundle\Filtre\FormationFiltre;
use Doctrine\ORM\EntityRepository;

class FormationRepository extends EntityRepository
{
    /**
     * Permets d'effectuer des recherches sur la table "Formation".
     *
     * @param FormationFiltre|null $filter les critères de filtre. Par défaut vaut null.
     * @return array liste des formations correspondants aux critères de filtre
     */

    public  function search(FormationFiltre $filter = null){
        //Si le filtre n'est pas null
        if ($filter !== null){
            //On crée l'objet QueryBuilder
            //(doc: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html)
            $query = $this->createQueryBuilder('u');

            //Pour chaque attribut de l'objet filtre, on vérifie s'il y a une valeur
            //et dans ce cas on ajoute une clause Where à la requette

            if ($filter->getLibelleCourt() !== null && trim($filter->getLibelleCourt()) !== ''){
                $query->andWhere('u.libelleCourt LIKE :libelleCourt')->setParameter('libelleCourt','%'. $filter->getLibelleCourt().'%');
            }
            if ($filter->getCodeFormation() !== null && trim($filter->getCodeFormation()) !== ''){
                $query->andWhere('u.codeFormation LIKE :codeFormation')->setParameter('codeFormation','%'.  $filter->getCodeFormation().'%');
            }
            if ($filter->getLieu() !== null) {
                $query->andWhere('u.lieu = :codeLieu')->setParameter('codeLieu',$filter->getLieu()->getCodeLieu());
            };

            $query->andWhere('u.archiver = false');
            //On retourne le résultat
            return $query->getQuery()->getResult();
        }else{
            //S'il n'y a pas de filtre on retourne tous les enregistrements
            return $this->findAll();
        }
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */


    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        if(array_key_exists('codeFormation', $criteria))
        {
            if(strlen($criteria['codeFormation'])<8)
            {
                $criteria['codeFormation'] = str_pad($criteria['codeFormation'], 8);
            }
        }
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }


    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        if(array_key_exists('codeFormation', $criteria))
        {
            if(strlen($criteria['codeFormation'])<8)
            {
                $criteria['codeFormation'] = str_pad($criteria['codeFormation'], 8);
            }
        }
        return parent::findOneBy($criteria, $orderBy);
    }


    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     * @param int|null $lockMode    One of the \Doctrine\DBAL\LockMode::* constants
     *                              or NULL if no specific lock mode should be used
     *                              during the search.
     * @param int|null $lockVersion The lock version.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function  find($id, $lockMode = null, $lockVersion = null)
    {
        if(strlen($id)<8)
        {
            $id = str_pad($id, 8);
        }
        return parent::find($id, $lockMode, $lockVersion);
    }

}