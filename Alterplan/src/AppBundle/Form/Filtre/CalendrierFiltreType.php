<?php
/**
 * Created by PhpStorm.
 * User: a590697
 * Date: 25/08/2017
 * Time: 10:08
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Form\Filtre;


use AppBundle\Repository\CalendrierRepository;
use AppBundle\Repository\FormationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendrierFiltreType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut',  TextType::class, array(
                'attr' => array('class'=> 'col s10 datepicker'),
                'required' => false,
            ))->add('dateFin',  TextType::class, array(
                'attr' => array('class'=> 'col s10 datepicker'),
                'required' => false,
            ))->add('titre',  TextType::class, array(
                'attr' => array('class'=> 'col s10'),
                'required' => false,
            ))->add('Formation',  EntityType::class, array(
                'attr' => array('class'=> 'col s10'),
                'class' => 'AppBundle:Formation',
                'placeholder' => 'Formation',
                'required' => false,
                'choice_label' => 'libelleCourt',
                'choice_value' => 'codeFormation'));
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Filtre\CalendrierFiltre'
        ));
    }
}