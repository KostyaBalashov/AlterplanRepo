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

/**
 * Class UtilisateurRepository gère l'accès aux utilisateurs en base
 * @package AppBundle\Repository
 */
class UtilisateurRepository extends EntityRepository
{
    /**
     * Permets d'effectuer des recherches sur la table "Utilisateur".
     *
     * @param UtilisateurFiltre|null $filter les critères de filtre. Par défaut vaut null.
     * @return array liste des utilisateurs correspondants aux critères de filtre
     */
    public function search(UtilisateurFiltre $filter = null)
    {
        //Si le filtre n'est pas null
        if ($filter !== null) {
            //On crée l'objet QueryBuilder
            //(doc: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html)
            $query = $this->createQueryBuilder('u');

            //Pour chaque attribut de l'objet filtre, on vérifie s'il y a une valeur
            //et dans ce cas on ajoute une clause Where à la requette

            if ($filter->getPrenom() !== null && trim($filter->getPrenom()) !== '') {
                $query->andWhere('u.prenom LIKE :prenom')->setParameter('prenom', $filter->getPrenom() . '%');
            }
            if ($filter->getNom() !== null && trim($filter->getNom()) !== '') {
                $query->andWhere('u.nom LIKE :nom')->setParameter('nom', $filter->getNom() . '%');
            }
            if ($filter->getIdentifiant() != null && trim($filter->getIdentifiant()) !== '') {
                $query->andWhere('u.username LIKE :login')->setParameter('login', $filter->getIdentifiant() . '%');
            }
            if ($filter->isAdministrateur() !== null) {
                $query->andWhere('u.isAdministrateur = :adm')->setParameter('adm', $filter->isAdministrateur());
            }

            //On retourne le résultat
            return $query->getQuery()->getResult();
        } else {
            //S'il n'y a pas de filtre on retourne tous les enregistrements
            return $this->findAll();
        }
    }
}