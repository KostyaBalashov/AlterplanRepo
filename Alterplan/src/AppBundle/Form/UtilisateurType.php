<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UtilisateurType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class, array(
                'label' => 'Nom',
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('username', TextType::class, array(
                'label' => "Identifiant",
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'Mot de passe',
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('checkPassword', PasswordType::class, array(
                'attr' => array(
                    'id'=>'check_password'
                ),
                'label' => 'Confirmation mot de passe',
                'mapped' => false,
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'label_attr' => array(
                    'class' => 'col s2'
                )
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
            $currentUser = $this->tokenStorage->getToken()->getUser();
            $user = $event->getData();
            $form = $event->getForm();

            if ($currentUser->getId() !== $user->getId()){
                $form->add('isAdministrateur', CheckboxType::class, array(
                    'required' => false,
                    'label' => 'Administrateur'
                ));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_utilisateur';
    }
}
