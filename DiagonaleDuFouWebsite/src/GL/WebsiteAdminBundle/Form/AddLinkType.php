<?php

namespace GL\WebsiteAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddLinkType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $lr = $options['entity_manager']->getRepository('GLWebsiteAdminBundle:Link');
        $nbrLink = $lr->getNumberOfLink();
        $orderChoices = [];
        for ($i = 1; $i <= $nbrLink + 1; $i++) {
            $orderChoices[$i] = $i;
        }

        $builder->add('order', ChoiceType::class, array(
                    'choices' => $orderChoices,
                    'multiple' => false,
                    'placeholder' => '-- Choix de l\'ordre',
                ))
                ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired('entity_manager');
    }

    public function getParent() {
        return LinkType::class;
    }

}
