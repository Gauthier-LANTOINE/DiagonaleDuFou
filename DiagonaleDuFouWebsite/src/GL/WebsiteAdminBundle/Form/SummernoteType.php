<?php

namespace GL\WebsiteAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SummernoteType extends AbstractType {

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'summernote'),
            'compound' => false
        ));
    }

    public function __construct(DataTransformerInterface $purifierTransformer) {
        $this->purifierTransformer = $purifierTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addViewTransformer($this->purifierTransformer);
    }

    public function getParent() {
        return TextareaType::class;
    }

}
