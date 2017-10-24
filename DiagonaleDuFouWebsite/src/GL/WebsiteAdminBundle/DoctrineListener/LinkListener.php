<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GL\WebsiteAdminBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use GL\WebsiteAdminBundle\Entity\Link;

/**
 * Description of LinkListener
 *
 * @author Gauthier_LANTOINE
 */
class LinkListener {

    public function prePersist(LifecycleEventArgs $args) {
        $link = $args->getObject();


        if (!$link instanceof Link) {
            return;
        }

        $repository = $args->getEntityManager()->getRepository('GLWebsiteAdminBundle:Link');

        if ($repository->isOrderAllreadyExist($link)) {

            $links = $repository->getLinksFromTheOrder($link->getOrder());

            foreach ($links as $linkToChangeOrder) {
                $linkToChangeOrder->setOrder($linkToChangeOrder->getOrder() + 1);
            }
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) {

//        $entity = $args->getObject();
//        $repository = $args->getEntityManager()->getRepository('GLWebsiteAdminBundle:Link');
//        $uow = $args->getEntityManager()->getUnitOfWork();
//
//        if (!$entity instanceof Link) {
//            return;
//        }
//
//        if ($args->hasChangedField('order')) {
//
//            $newOrder = $args->getNewValue('order');
//            $oldOrder = $args->getOldValue('order');
//            
//            if ($oldOrder < $newOrder) {
//                $links = $repository->getLinksToModifyOrder($oldOrder,$newOrder,$entity->getId());
//
//                foreach ($links as $linkToChangeOrder) {
//                    $linkToChangeOrder->setOrder($linkToChangeOrder->getOrder() - 1);
//                    $uow->scheduleForUpdate($linkToChangeOrder);
//                }
//                
//            }
//
//            if ($oldOrder > $newOrder) {
//                $links = $repository->getLinksToModifyOrder($newOrder,$oldOrder,$entity->getId());
//
//                foreach ($links as $linkToChangeOrder) {
//                    $linkToChangeOrder->setOrder($linkToChangeOrder->getOrder() + 1);
//                    $uow->scheduleForUpdate($linkToChangeOrder);
//                }
//                
//            }
//        }
    }
    

}
