<?php

namespace GL\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstName', TextType::class, array('required' => true))
                ->add('lastName', TextType::class, array('required' => true))
                ->add('birthDate', BirthdayType::class , array(
                    'required'=>true,
                    'format' => "dd/MM/yyyy"
                ))
                ->add('plainPassword', PasswordType::class, array('required' => true))
                ->add('email', EmailType::class, array('required' => true))
                ->add('phoneHome', TextType::class,  array('required' => false))
                ->add('mobilePhone', TextType::class, array('required' => false))
                ->add('allowImageRights', CheckboxType::class, array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'GL\UserBundle\Entity\User'
        ));
    }

    
    public function getBlockPrefix()
    {
        return 'gl_websiteadminbundle_articles';
    }

}
