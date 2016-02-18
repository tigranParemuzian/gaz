<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 1/27/16
 * Time: 11:34 PM
 */

namespace Gaz\MainBundle\Entity\Repositories;


use Doctrine\ORM\EntityRepository;

class LoginProviderRepositories extends EntityRepository
{
    public function findByCode($code, $date)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
        ->select('lp')
        ->from('GazMainBundle:LoginProvider', 'lp')
        ->leftJoin('lp.worker', 'w')
        ->where('w.code = :code')
        ->andWhere('lp.loginTime >= :login_time')
        ->orderBy('lp.id', 'ASC')
        ->setParameter('code', $code)
        ->setParameter('login_time', $date)
        ->setMaxResults(1)->getQuery()->getOneOrNullResult()
            ;
    }

}