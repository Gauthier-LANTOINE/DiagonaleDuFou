<?php

namespace GL\WebsiteAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MemberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, array('required' => true))
                ->add('lastName', TextType::class, array('required' => true))
                ->add('birthDate', BirthdayType::class , array(
                    'required'=>true,
                    'format' => "dd/MM/yyyy"
                ))
                ->add('email', EmailType::class, array('required' => false))
                ->add('phoneHome', TextType::class,  array('required' => false))
                ->add('mobilePhone', TextType::class, array('required' => false))
                ->add('allowImageRights', CheckboxType::class, array('required' => false))
                ->add('numLicence', TextType::class, array('required' => false))
                ->add('wayNumber', IntegerType::class, array('required' => false))
                ->add('way', TextType::class, array('required' => false))
                ->add('additionalAddress', TextType::class, array('required' => false))
                ->add('city', TextType::class, array('required' => false))
                ->add('postalCode', TextType::class, array('required' => false))
                ->add('country', ChoiceType::class, array(
                    'choices' => array(
                        'France'=> 'France',
                        'Belgique' => 'Belgique'
                    ),
                    'multiple'     => false,
                    'placeholder' => '-- Choix du Pays',
                    'required'=> false
                ))
                ->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GL\WebsiteAdminBundle\Entity\Member'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gl_websiteadminbundle_member';
    }


}
