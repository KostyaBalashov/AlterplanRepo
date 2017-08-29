<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 29/08/2017
 * Time: 13:04
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Service;


use Doctrine\DBAL\Connection;

class AssociationModuleSousGroupService
{
    private $conn;
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function insert($codeSousGroupe, $modules){
        foreach ($modules as $idModule){
            $this->conn->insert('AssocitionModuleSousGroupeModule', array(
                'CodeSousGroupeModule' => $codeSousGroupe,
                'IdModule' => $idModule
            ));
        }
    }

    public function delete($codeSousGroupe, $modules){
        $sal = 'DELETE FROM AssocitionModuleSousGroupeModule WHERE CodeSousGroupeModule = ? AND IdModule IN (?)';
        $this->conn->executeQuery($sal, array($codeSousGroupe, $modules), array(\PDO::PARAM_INT, Connection::PARAM_INT_ARRAY));
    }
}