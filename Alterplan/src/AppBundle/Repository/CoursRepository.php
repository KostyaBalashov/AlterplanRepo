<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 29/10/2017
 * Time: 15:02
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;


use AppBundle\Entity\Calendrier;
use AppBundle\Entity\Module;
use Doctrine\ORM\EntityRepository;

class CoursRepository extends EntityRepository
{
    public function search(Module $module, Calendrier $calendrier)
    {
        $qb = $this->createQueryBuilder('c');

        if ($module != null) {
            $qb->andWhere('c.module = :module')->setParameter('module', $module);
        }

        if ($calendrier != null) {
            $qb->andWhere('c.debut BETWEEN :dateDebut AND :dateFin')
                ->andWhere('c.fin <= :dateFin')
                ->setParameter('dateDebut', $calendrier->getDateDebut()->format('Y-m-d'))
                ->setParameter('dateFin', $calendrier->getDateFin()->format('Y-m-d'));
        }

        return $qb->getQuery()->getResult();
    }
}