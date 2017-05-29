<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use GL\WebsiteAdminBundle\Repository\MemberRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChallengeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $builder->add('memberChallenged',EntityType::class, array(
                      'class' => 'GLWebsiteAdminBundle:Member',
                      'multiple'     => false,
                      'placeholder' => '-- Sélectionner un membre à défier',
                      'choice_label' => function ($member) {
                        return $member->getFirstName().' '.$member->getLastName();
                      },
                      'query_builder' => function (MemberRepository $mr)use($options){
                          $currentUser= $options['token_storage']->getToken()->getUser();
                          return $mr->getOtherMemberWithUserAccountQueryBuilder($currentUser);
                      }
        ))
                ->add('challengerColor',ChoiceType::class, array(
                    'choices' => array(
                        'blanc'=> 'blanc',
                        'noir' => 'noir'
                    ),
                    'multiple'     => false,
                    'placeholder' => '-- Choix de la couleur',
                ))
                ->add('save',SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Challenge'
        ));
        
        $resolver->setRequired('token_storage');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_challenge';
    }


}
