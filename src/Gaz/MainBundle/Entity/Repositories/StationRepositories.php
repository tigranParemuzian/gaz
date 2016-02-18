<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 1/8/16
 * Time: 11:57 AM
 */

namespace Gaz\MainBundle\Entity\Repositories;


use Doctrine\ORM\EntityRepository;

class StationRepositories extends EntityRepository
{
    public function findStation()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT s FROM GazMainBundle:Station s
                            ')
            ->setMaxResults(1)
            ->getOneOrNullResult()
            ;
    }

}