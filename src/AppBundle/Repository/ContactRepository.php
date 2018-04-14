<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function getContactsNotExistInGroup($groupId)
    {
        /*
         * via QB
         */
        $sq = $this->getEntityManager()->createQueryBuilder()
            ->select('c.id')
            ->from('AppBundle:Contact', 'c')
            ->leftJoin('c.groups', 'g')
            ->where('g.id = :groupId')
            ->setParameter(':groupId', $groupId)
            ->getQuery()
            ->getResult();

        $q = $this->getEntityManager()->createQueryBuilder();

        return $q->select('c')
            ->from('AppBundle:Contact', 'c')
            ->where($q->expr()->notIn('c.id', ':sq'))
            ->setParameter('sq', $sq)
            ->getQuery()->getResult();

        /* via DQL
        return $this->getEntityManager()
            ->createQuery('select c from AppBundle:Contact c
                      where c.id
                      not in(SELECT co.id FROM AppBundle:Contact co JOIN co.groups g WHERE g.id = :groupId)')
            ->setParameter(':groupId', $groupId)
            ->getResult();
        */
    }
}