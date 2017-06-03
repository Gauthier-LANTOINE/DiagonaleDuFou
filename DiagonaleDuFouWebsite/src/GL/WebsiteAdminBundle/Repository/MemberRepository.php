<?php

namespace GL\WebsiteAdminBundle\Repository;

use GL\UserBundle\Entity\User;

/**
 * MemberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MemberRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Obtiens la liste des utilisateurs qui ne sont pas activés
     * 
     * @return array()
     */
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
    
    /**
     * Retourne un QueryBuilder permettant d'obtenir la liste des membres
     * qui ont un compte utilisateur activé à part celui passé en paramètre.
     * 
     * @param User $currentUser
     * @return array()
     */
    public function getOtherMemberWithUserAccountQueryBuilder(User $currentUser)
    {
        $queryBuilder = $this->createQueryBuilder('m')
                      ->innerJoin('m.user', 'u')
                      ->where('u.id != :id')
                      ->setParameter('id', $currentUser->getId())
                      ->andWhere('u.enabled = true');
        return $queryBuilder;
    }
}
