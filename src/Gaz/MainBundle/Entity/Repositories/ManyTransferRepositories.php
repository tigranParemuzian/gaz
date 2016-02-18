<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 1/29/16
 * Time: 12:44 PM
 */

namespace Gaz\MainBundle\Entity\Repositories;


use Doctrine\ORM\EntityRepository;

class ManyTransferRepositories extends EntityRepository
{
    public function findBySenderCode($code)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT mt.cash, mt.created FROM GazMainBundle:ManyTransfer mt
                          LEFT JOIN mt.sender sd
                          WHERE sd.code = :code AND mt.created = (SELECT MAX(mt1.created) FROM GazMainBundle:ManyTransfer mt1
                                                                  LEFT JOIN mt1.sender sd1
                                                                  WHERE sd1.code = :code)
                          ')
            ->setParameter('code', $code)
            ->getOneOrNullResult()
            ;
    }

    public function findMax()
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('mt')
            ->from('GazMainBundle:ManyTransfer', 'mt')
            ->orderBy('mt.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()->getOneOrNullResult()
        ;
    }

}