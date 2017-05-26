<?php

namespace GL\WebsiteAdminBundle\Repository;

/**
 * MemberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MemberRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDisabledUsers()
    {
        $result = $this->createQueryBuilder('m')
                       ->innerJoin('m.user', 'u')
                       ->addSelect('u')
                       ->where('u.enabled = false')
                       ->orderBy('m.registerDate', 'DESC')
                       ->getQuery()
                       ->getResult();
        
        return $result;
    }
    
    public function getOtherMemberWithUserAccountQueryBuilder($currentUser)
    {
        $queryBuilder = $this->createQueryBuilder('m')
                      ->innerJoin('m.user', 'u')
                      ->where('u.id != :id')
                      ->setParameter('id', $currentUser->getId());
        return $queryBuilder;
    }
}
