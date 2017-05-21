<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GL\WebsiteAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use GL\UserBundle\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Formulaire utilisateur rempli par l'administrateur
 */
class UserAdminType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->remove('plainPassword')
                ->add('save', SubmitType::class);
    }

    public function getParent() {
        return UserType::class;
    }

}
