<?php

namespace GL\WebsiteAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use GL\WebsiteAdminBundle\Form\SummernoteType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticlesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title',TextType::class)
                ->add('subtitle',TextType::class)
                ->add('subCategory', EntityType::class, array(
                      'class'        => 'GLWebsiteAdminBundle:SubCategoryArticle',
                      'choice_label' => 'name',
                      'multiple'     => false,
                      'placeholder' => '-- Séléctionner une catégorie',
                      'group_by' => function($val, $key, $index) {
                        return $val->getCategory()->getName();
                      }))
                ->add('content', SummernoteType::class)
                ->add('save',SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GL\WebsiteAdminBundle\Entity\Articles'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gl_websiteadminbundle_articles';
    }


}
