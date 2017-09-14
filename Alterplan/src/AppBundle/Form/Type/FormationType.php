<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 07/09/2017
 * Time: 16:54
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Form\Type;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'required' => false,
            'placeholder' => 'Formation',
            'class' => 'AppBundle\Entity\Formation',
            'choice_value' => 'codeFormation',
            'trim' => false,
            'choice_label' => function ($item){
                return $item->getLibelleLong().' ('.$item->getLibelleCourt().')';
            },
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('f')
                    ->andWhere('f.archiver = false');
            }
        ));
    }

    public function getParent()
    {
        return EntityType::class;
    }
}