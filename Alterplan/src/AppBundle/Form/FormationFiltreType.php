<?php
/**
 * Created by PhpStorm.
 * User: penno
 * Date: 01/08/2017
 * Time: 17:06
 *//*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationFiltreType  extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelleCourt',TextType::class, array(
            'required' => false
            ))
            ->add('codeFormation', TextType::class, array(
                'required' => false
            ))
            ->add('lieu', ChoiceType::class, array(
                'required' => false,
                'label' => 'Lieu',
//               A voir comment faire pour mettre les données de la bdd
//                'choices' => array(
//                    'Type d\'utilisateur' => null,
//                    'Administrateur' => true,
//                    'Utilisateur autorisé' => false
//                )
            ));
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Filtre\FormationFiltre'
        ));
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return 'appbundle_formation_filtre';
    }
}