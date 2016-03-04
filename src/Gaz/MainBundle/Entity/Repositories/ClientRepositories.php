<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/25/15
 * Time: 6:12 PM
 */
namespace Gaz\MainBundle\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

class ClientRepositories extends EntityRepository
{

	/**
	 * @param $code
	 * @return array
	 */
	public function findClientGroupType($code)
	{
		return $this->getEntityManager()
			->createQuery('SELECT co.groupType as groupe, c.name as name, c.code as code
							FROM GazMainBundle:Client c
							LEFT JOIN c.company co
							WHERE c.code = :code')
			->setParameter('code', $code)
			->getOneOrNullResult()
		;
	}

	/**
	 * @return mixed
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function findClients($state)
	{
		if($state == '1')
		{
			$query = $this->getEntityManager()
				->createQuery('SELECT cl
							FROM GazMainBundle:Client cl
							LEFT JOIN cl.company co
							WHERE co.groupType =6 OR co.groupType =3
							ORDER BY cl.id
							')
				->getResult();
		}
		else {
			$query = $this->getEntityManager()
				->createQuery('SELECT c
							FROM GazMainBundle:Client c
							LEFT JOIN c.company co
							WHERE co.groupType != 6 AND co.groupType != 3
							ORDER BY c.id
							')->getResult();
		}
		return $query;
	}

	public function findClientDataByCode($code)
	{
		return $this->getEntityManager()
			->createQuery('SELECT c1.name as name
							FROM GazMainBundle:Client c1
							LEFT JOIN c1.company cp
							LEFT JOIN c1.financeBuy fb1
							WHERE c1.code =:code
						')
			->setParameter('code',$code)
			->getOneOrNullResult()
			;

	}

	/**
	 * @param $worker
	 * @param $cash
	 * @param $director
	 * @return array
	 *
	 */
	public function findManyTransferData($worker, $director)
	{
		return $this->getEntityManager()
			->createQuery('SELECT c1 AS sender, c2 AS recipient
							FROM GazMainBundle:Client c1
							JOIN GazMainBundle:ManyTransfer mt WITH mt.sender = c1
							JOIN GazMainBundle:Client c2 WITH c2.code = :director
							WHERE c1.code = :worker
						')
			->setParameters(array('worker'=>$worker, 'director'=>$director))
			->getResult()
			;
	}

	/**
	 * @param $worker
	 * @param $director
	 * @return array
	 */
	public function findManyTransfer($worker, $director)
	{
		return $this->getEntityManager()
			->createQuery('SELECT c1 AS sender, c2 AS recipient
							FROM GazMainBundle:Client c1
							JOIN GazMainBundle:Client c2 WITH c2.code = :director
							WHERE c1.code = :worker
						')
			->setParameters(array('worker'=>$worker, 'director'=>$director))
			->getResult()
			;
	}
}