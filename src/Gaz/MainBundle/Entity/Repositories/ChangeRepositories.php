<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 1/29/16
 * Time: 5:32 PM
 */

namespace Gaz\MainBundle\Entity\Repositories;


use Doctrine\ORM\EntityRepository;

class ChangeRepositories extends EntityRepository
{
    public function findMax()
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ch')
            ->from('GazMainBundle:Change', 'ch')
            ->where('ch.ended IS NULL')
            ->andWhere('ch.cash = 0')
            ->orderBy('ch.id', 'DESC')
            ->setMaxResults(1)
        ;
        return $query->getQuery()->getOneOrNullResult();
    }

    public function findMaxResult()
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ch')
            ->from('GazMainBundle:Change', 'ch')
            ->where('ch.ended IS NOT NULL')
            ->andWhere('ch.cash > 0')
            ->orderBy('ch.id', 'DESC')
            ->setMaxResults(1)
        ;
        return $query->getQuery()->getOneOrNullResult();
//        return $this->getEntityManager()
//            ->createQuery('SELECT ch FROM GazMainBundle:Change ch
//                            ORDER BY ch.id ASC
//                            ')
//            ->getMaxResults(1)
//            ;
    }

}