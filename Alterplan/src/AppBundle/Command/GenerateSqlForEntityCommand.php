<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 19/07/2017
 * Time: 22:08
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Command;


use Doctrine\DBAL\Schema\Comparator;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSqlForEntityCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('generate_sql_for');
        $this->setDescription('Génère les scripts sql pour une entité.');
        $this->addArgument('entity', InputArgument::REQUIRED, 'L\'entité à générer (ex: AppBundle:Utilisateur)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        /* Doctrine tool class for create/drop/update database schemas
        based on metadata class descriptors */
        $tool = new SchemaTool($em);

        /* Doctrine tool class for comparing differences between database
        schemas */
        $comparator = new Comparator();

        /* Create an empty schema */
        $fromSchema = $tool->getSchemaFromMetadata(array());

        /* Create the schema for our class */
        $toSchema = $tool->getSchemaFromMetadata(
            array($em->getClassMetadata($input->getArgument('entity')))
        );

        /* Compare schemas, and write result as SQL */
        $schemaDiff = $comparator->compare($fromSchema, $toSchema);
        $sql = $schemaDiff->toSql(
            $em->getConnection()->getDatabasePlatform()
        );
        $output->writeln($sql);
    }
}