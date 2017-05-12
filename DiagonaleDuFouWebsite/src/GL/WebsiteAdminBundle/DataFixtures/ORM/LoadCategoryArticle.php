<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GL\WebsiteAdminBundle\Entity\CategoryArticle;

class LoadCategoryArticle extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categoryNames=array('Vie du club','Actualité échiquéenne','Apprentissage','Jeu en différé','Administration');
        
        foreach ($categoryNames as $categoryName)
        {
            $category= new CategoryArticle();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference($categoryName, $category);
        }
        
        
        $manager->flush();

        
    }

    public function getOrder()
    {
        
        return 1;
    }
}