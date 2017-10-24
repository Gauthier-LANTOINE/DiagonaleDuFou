<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GL\WebsiteAdminBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use GL\WebsiteAdminBundle\Entity\Link;

/**
 * Description of LinkService
 *
 * @author Gauthier_LANTOINE
 */
class LinkService {
    
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em=$em;
    }
    
    public function reorderLink(Link $link){
        
            $repository =$this->em->getRepository('GLWebsiteAdminBundle:Link');
            $uow = $this->em->getUnitOfWork();
            $linkOriginalValue=$uow->getOriginalEntityData($link);
            
            $newOrder = $link->getOrder();
            $oldOrder = $linkOriginalValue['order'];
            
            if ($oldOrder === $newOrder) {
                return;
            }

            if ($oldOrder < $newOrder) {
                $links = $repository->getLinksToModifyOrder($oldOrder,$newOrder,$link->getId());

                foreach ($links as $linkToChangeOrder) {
                    $linkToChangeOrder->setOrder($linkToChangeOrder->getOrder() - 1);
                }
                
            }

            if ($oldOrder > $newOrder) {
                $links = $repository->getLinksToModifyOrder($newOrder,$oldOrder,$link->getId());

                foreach ($links as $linkToChangeOrder) {
                    $linkToChangeOrder->setOrder($linkToChangeOrder->getOrder() + 1);
                }
                
            }
        
    }
}
