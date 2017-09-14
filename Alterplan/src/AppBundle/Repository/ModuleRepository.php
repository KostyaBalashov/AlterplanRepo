<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 13/08/2017
 * Time: 20:50
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;


use AppBundle\Entity\Formation;
use AppBundle\Entity\ModuleParUnite;
use AppBundle\Entity\OrdreModule;
use AppBundle\Entity\SousGroupeModule;
use AppBundle\Entity\UniteFormation;
use AppBundle\Entity\UniteParFormation;
use AppBundle\Filtre\ModuleFiltre;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class ModuleRepository extends EntityRepository
{
    public function search(ModuleFiltre $filtre = null){
        if ($filtre !== null){
            $qb = $this->createQueryBuilder('m');
            $this->joinOnFormation($qb);
            if ($filtre->getTitre() !== null
                && '' !== trim($filtre->getTitre())){
                $qb->andWhere('m.libelle LIKE :titre')->setParameter('titre', $filtre->getTitre().'%');
            }
            if ($filtre->getFormation() !== null){
                $qb->andWhere('f.codeFormation = :code')
                    ->setParameter('code', $filtre->getFormation()->getCodeFormation());
            }
            if ($filtre->getLieu() !== null){
                $qb->andWhere('f.codeLieu = :codeLieu')
                    ->setParameter('codeLieu', $filtre->getLieu()->getCodeLieu());
            }
            $qb->andWhere('f.archiver = false')->andWhere('m.archiver = false');
            return $qb->getQuery()->getResult();
        }else{
            return $this->findAll();
        }
    }

    private function joinOnFormation(QueryBuilder $qb){
        return $qb->join(ModuleParUnite::class, 'mp', Join::WITH, 'm.idModule = mp.module')
            ->join(UniteParFormation::class, 'uf', Join::WITH, 'mp.uniteParFormation = uf.id')
            ->join(Formation::class, 'f', Join::WITH, 'uf.formation = f.codeFormation');
    }
}