<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/25/15
 * Time: 6:12 PM
 */
namespace Gaz\MainBundle\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

class CompanyRepositories extends EntityRepository
{

	/**
	 * @return array
	 */
	public function findAllCompany($status)
	{
		if($status == 1)
		{
			$query = $this->getEntityManager()
				->createQuery('SELECT c
							FROM GazMainBundle:Company c
							WHERE c.groupType !=4 AND c.groupType !=5
							')
				->getResult();
		}
		else {
			$query = $this->getEntityManager()->createQuery('SELECT c
							FROM GazMainBundle:Company c
							WHERE c.groupType !=6 AND c.groupType !=3')->getResult();
		}
		return $query;
	}

//	/**
//	 *
//	 */
//	public function getDataByIp($ip)
//	{
//
//		return $this->getEntityManager()
//			->createQuery("SELECT c.id as id, c.name as name, im.providerReference as image, p.sale as sale, p.buy as buy, p.updated
//							FROM BankMainBundle:Currency c
//							LEFT JOIN c.media im
//							LEFT JOIN c.price p
//							LEFT JOIN p.brunch b
//							WHERE b.ip = :ip AND b.state = 0 AND ( p.updated >= ( SELECT p1.updated
//							FROM BankMainBundle:Currency c1
//								LEFT JOIN c1.price p1
//								LEFT JOIN p1.brunch b1
//								WHERE b1.state = 1 AND c1.id = c.id))
//							")
//			->setParameter('ip', $ip)
//			->getResult()
//		;
//	}
}