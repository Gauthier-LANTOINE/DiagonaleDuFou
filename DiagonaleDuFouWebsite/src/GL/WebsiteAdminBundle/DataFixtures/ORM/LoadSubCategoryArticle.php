<?php

namespace GL\WebsiteAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GL\WebsiteAdminBundle\Entity\SubCategoryArticle;

class LoadSubCategoryArticle extends AbstractFixture implements OrderedFixtureInterface
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
      $subCategoryArticle->setCategory($this->getReference('Vie du club'));
      
      $manager->persist($subCategoryArticle);
    }

    
    $manager->flush();
  }
  
  public function getOrder()
    {
        return 2;
    }
}