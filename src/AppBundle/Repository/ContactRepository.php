<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function getContacts()
    {
        return $this->getEntityManager()
            ->createQuery('select c from AppBundle:Contact c')
            ->getResult();
    }
}