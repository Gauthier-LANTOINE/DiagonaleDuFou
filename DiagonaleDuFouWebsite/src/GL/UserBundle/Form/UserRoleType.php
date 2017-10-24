<?php

namespace GL\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserRoleType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('roles', ChoiceType::class, array(
                    'label' => false,
                    'required'=>false,
                    'choices'  => array(
                            'Auteur'    => 'ROLE_AUTHOR',
                            'Modérateur'    => 'ROLE_MODERATOR',
                            'Administrateur'     => 'ROLE_ADMIN',
                            'Super Administrateur' => 'ROLE_SUPER_ADMIN',
                        ),
                    'multiple' => TRUE,
                    'expanded' => true, 
                    ));
                               
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'GL\UserBundle\Entity\User'
        ));
    }


}
