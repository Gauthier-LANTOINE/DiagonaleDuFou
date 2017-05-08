<?php

namespace GL\WebsiteAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GL\WebsiteAdminBundle\Entity\SubCategoryArticle;

class LoadSubCategoryArticle implements FixtureInterface
{

  public function load(ObjectManager $manager)
  {
    // Liste des noms à ajouter
    $names = array(
      'Compétitions',
      'Loisirs',
      'Info pratiques',
      'Info légales'
    );

    foreach ($names as $name) {
      
      $subCategoryArticle = new SubCategoryArticle();
      $subCategoryArticle->setName($name);

      
      $manager->persist($subCategoryArticle);
    }

    
    $manager->flush();
  }
}