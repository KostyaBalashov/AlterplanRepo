<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 13/08/2017
 * Time: 22:54
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Repository;


use AppBundle\Entity\Module;
use Doctrine\ORM\EntityRepository;

class OrdreModuleRepository extends EntityRepository
{
    public function remove($codeOrdreModule){
        $qb = $this->createQueryBuilder('om');
        $qb->delete('AppBundle:OrdreModule', 'om')
            ->where('om.codeOrdreModule = :code')->setParameter('code', $codeOrdreModule);
        $qb->getQuery()->execute();
    }

    public function insert($codeFormation, $idModule){
        $data = array('CodeFormation' => $codeFormation, 'IdModule' => $idModule);
        $this->getEntityManager()->getConnection()->insert('OrdreModule', $data);
        return $this->getEntityManager()->getConnection()->lastInsertId();
    }

    public function getOrdreModuleByModule(Module $module){
        if ($module){
            $qb = $this->createQueryBuilder('om');
            $qb->andWhere('om.module = :idModule')->setParameter('idModule', $module->getIdModule());

            return $qb->getQuery()->getResult();
        }

        return null;
    }
}