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
use AppBundle\Filtre\CalendrierFiltre;
use AppBundle\Filtre\StagiaireParEntrepriseFiltre;
use Doctrine\ORM\EntityRepository;
use DateTime;

class CalendrierRepository extends EntityRepository
{

   /**
     * @param CalendrierFiltre|null $filter
     * @return mixed
     */
    public function search(CalendrierFiltre $filter = null){
        //Si le filtre n'est pas null
        if ($filter !== null){

            // On effectue les jointures avec les tables stagiaire et entreprise
            $query = $this->createQueryBuilder('calendrier');


            // Si le champ titre est saisi, on inclut la recherche par le titre du calendrier
            if ($filter->getTitre() !== null && trim($filter->getTitre()) !== ''){
                $query->andWhere('calendrier.titre LIKE :titre')->setParameter('titre','%'.$filter->getTitre().'%');
            }

            // Si le champ date de début est saisi, on inclut la recherche par la date de début de formation
            if ($filter->getDateDebut() !== null && trim($filter->getDateDebut()) !== ''){
                $dateDebut = new DateTime($filter->getDateDebut());
                $dateDebut = $dateDebut->format('Y-m-d');
                $query->andWhere('calendrier.dateDebut = :dateDebut')->setParameter('dateDebut',$dateDebut);
            }

            // Si le champ date de fin est saisi, on inclut la recherche par la date de fin de formation
            if ($filter->getDateFin() !== null && trim($filter->getDateFin()) !== ''){
                $dateFin = new DateTime($filter->getDateFin());
                $dateFin = $dateFin->format('Y-m-d');
                $query->andWhere('calendrier.dateFin = :dateFin')->setParameter('dateFin',$dateFin);
            }

            // Si le une formation est sélectionnée, on inclut la recherche par le libelleCourt de la formation
            if ($filter->getFormation() !== null){
                $query->andWhere('calendrier.formation = :codeFormation')->setParameter('codeFormation',$filter->getFormation());
            }

            $query->andWhere('calendrier.isModele = :isModele')->setParameter('isModele',$filter->isModele());

            //On retourne le résultat
            return $query->getQuery()->getResult();
        }else{
            //S'il n'y a pas de filtre on retourne 50 calendriers
            $query = $this->createQueryBuilder('calendrier')
                ->setMaxResults(50);

            return $query->getQuery()->getResult();
        }
    }
}