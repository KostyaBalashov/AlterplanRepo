<?php
/*
This file is part of Alterplan. 
 
Alterplan is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. 
 
Alterplan is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details. 
 
You should have received a copy of the GNU Affero General Public License along with Alterplan. If not, see <http://www.gnu.org/licenses/>.
*/


namespace AppBundle\Form;


use AppBundle\Form\Type\FormationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendrierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, array(
            'label' => 'Titre',
            'label_attr' => array(
                'class' => 'col s2'
            )
        ))
            ->add('formation', FormationType::class, array(
                'required' => true,
                'trim' => false,
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('dateDebut', TextType::class, array(
                "attr" => array(
                    "class" => "datepicker",
                ),
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('dateFin', TextType::class, array(
                "attr" => array(
                    "class" => "datepicker",
                ),
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $calendrier = $event->getData();
            $form = $event->getForm();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Calendrier'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_calendrier';
    }
}