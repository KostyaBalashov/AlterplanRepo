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
use AppBundle\Entity\OrdreModule;
use AppBundle\Entity\SousGroupeModule;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class ModuleRepository extends EntityRepository
{
    public function getFormationModules(Formation $formation){
        $modules = new  ArrayCollection();

        if ($formation){
            foreach ($formation->getUnitesParFormation() as $uniteParFormation){
                foreach ($uniteParFormation->getModulesParUnite() as $moduleParUnite){
                    if ($moduleParUnite && ($moduleParUnite->getModule())){
                        $modules->add($moduleParUnite->getModule());
                    }
                }
            }
        }

        return $modules;
    }

    public function getOrdreModules(OrdreModule $ordreModule){
        $modules = new  ArrayCollection();

        if ($ordreModule){
            foreach ($ordreModule->getGroupes() as $groupe){
                if ($groupe->getSousGroupe1())
                    $modules->add($this->getModulesFromSousGroupe($groupe->getSousGroupe1()));

                if ($groupe->getSousGroupe2())
                    $modules->add($this->getModulesFromSousGroupe($groupe->getSousGroupe2()));
            }
        }

        return $modules;
    }

    private function getModulesFromSousGroupe(SousGroupeModule $sousGroupe){
        $modules = new ArrayCollection();
        if ($sousGroupe){
            if ($sousGroupe->getModule1())
                $modules->add($sousGroupe->getModule1());
            if ($sousGroupe->getModule2())
                $modules->add($sousGroupe->getModule2());
            if ($sousGroupe->getModule3())
                $modules->add($sousGroupe->getModule3());
            if ($sousGroupe->getModule4())
                $modules->add($sousGroupe->getModule4());
        }
        return $modules;
    }
}