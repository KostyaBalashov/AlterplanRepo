<?php
/**
 * Created by PhpStorm.
 * User: Ravet
 * Date: 06/08/2017
 * Time: 15:30
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;


use AppBundle\Entity\Entreprise;
use AppBundle\Entity\Stagiaire;
use AppBundle\Filtre\StagiaireParEntrepriseFiltre;
use Doctrine\ORM\EntityRepository;

class StagiaireParEntrepriseRepository extends EntityRepository
{
    /**
     * @param StagiaireParEntrepriseFiltre|null $filter
     * @return mixed
     */
    public function search(StagiaireParEntrepriseFiltre $filter = null){
        //Si le filtre n'est pas null
        if ($filter !== null){

            // On effectue les jointures avec les tables stagiaire et entreprise
            $query = $this->createQueryBuilder('ste')
                ->innerJoin('ste.stagiaire','st')
                ->innerJoin('ste.entreprise','e');

            // Si le champ nom est saisi, on inclut la recherche par le nom du stagiaire
            if ($filter->getNom() !== null && trim($filter->getNom()) !== ''){
                $query->andWhere('st.nom LIKE :nom')->setParameter('nom','%'. $filter->getNom().'%');
            }

            // Si le champ prénom est saisi, on inclut la recherche par le prénom du stagiaire
            if ($filter->getPrenom() !== null && trim($filter->getPrenom()) !== ''){
                $query->andWhere('st.prenom LIKE :prenom')->setParameter('prenom','%'. $filter->getPrenom().'%');
            }

            // Si le champ email est saisi, on inclut la recherche par l'email du stagiaire
            if ($filter->getEmail() !== null && trim($filter->getEmail()) !== ''){
                $query->andWhere('st.email LIKE :email')->setParameter('email','%'. $filter->getEmail().'%');
            }

            // Si le champ entreprise est saisi, on inclut la recherche par le nom de l'entreprise
            if ($filter->getEntreprise() !== null && trim($filter->getEntreprise()) !== ''){
                $query->andWhere('e.raisonsociale LIKE :raisonsociale')->setParameter('raisonsociale','%'. $filter->getEntreprise().'%');
            }
            //On retourne le résultat
            return $query->getQuery()->getResult();
        }else{
            //S'il n'y a pas de filtre on retourne tous les enregistrements
            return $this->findAll();
        }
    }
}