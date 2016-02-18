<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/25/15
 * Time: 6:12 PM
 */
namespace Gaz\MainBundle\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

class FinanceRepositories extends EntityRepository
{

	/**
	 * @return array
	 */
	public function findClientDate($code)
	{
		return $this->getEntityManager()->createQuery('SELECT f.balance as balance, cb.name as name,
							FROM GazMainBundle:Finance f
							LEFT JOIN f.clientBuy cb
							LEFT JOIN cb.company
							WHERE cb.code =:code
							ORDER BY f.created ASC
							')->setParameter('code', $code)->getArrayResult();
	}

	public function findFinanceByTerminal($number)
	{
		return $this->getEntityManager()
			->createQuery('SELECT f1.price, f1.created FROM GazMainBundle:Finance f1
 							LEFT JOIN f1.terminal t1
 							WHERE t1.number = :number AND f1.created = (
 								SELECT MAX(f2.created) FROM GazMainBundle:Finance f2
 								LEFT JOIN f2.terminal t2
 								WHERE t2.number = :number) ')
			->setParameter('number', $number)
			->getOneOrNullResult();
	}

	public function findByFilter($data = null)
	{
		$query =  $this->getEntityManager()
			->createQueryBuilder();
			$query->select('fi.id as id, fi.price as price, fi.balance as balance,
							fi.deposit as deposit, fi.residue as residue,
							fi.created as created, sCl.name as worker,
							bCl.name as buyer, t.number as terminal')
			->from('GazMainBundle:Finance','fi')
				->leftJoin('fi.clientSale', 'sCl')
				->leftJoin('fi.clientBuy', 'bCl')
				->leftJoin('fi.terminal', 't')
			->orderBy('fi.id', 'ASC');

		if(isset($data))
		{
			if(isset($data['id']) && $data['id'] !=null){
				$query->where('fi.id = :id')
					->setParameter('id', $data['id']);
			}

			if(isset($data['terminal']) && $data['terminal'] != null){
				$query->andWhere('t.number = :terminal')
					->setParameter('terminal', $data['terminal']);
			}

			if(isset($data['buyer']) && $data['buyer'] != null){
				$query->andWhere('bCl.name = :buyer')
					->setParameter('buyer', $data['buyer']);
			}

			if(isset($data['worker']) && $data['worker'] != null){
				$query->andWhere('sCl.name = :worker')
					->setParameter('worker', $data['worker']);
			}

			if(isset($data['price']) && $data['price'] != null){
				$query->andWhere('fi.price = :price')
					->setParameter('price', $data['price']);
			}

			if(isset($data['balance']) && $data['balance'] != null){
				$query->andWhere('fi.balance = :balance')
					->setParameter('balance', $data['balance']);
			}

			if(isset($data['deposit']) && $data['deposit'] != null){
				$query->andWhere('fi.deposit = :deposit')
					->setParameter('deposit', $data['deposit']);
			}

			if(isset($data['residue']) && $data['residue'] != null){
				$query->andWhere('fi.residue = :residue')
					->setParameter('residue', $data['residue']);
			}
		}
		return $query->getQuery()->getResult();
	}

	public function findMaxId()
	{
		return $this->getEntityManager()
			->createQuery('SELECT MAX(f.id) FROM GazMainBundle:Finance f')
			->getOneOrNullResult();
	}

	/**
	 * This repository find Last crated data for worker
	 * @return array
	 */
	public function findCount($terminal)
	{
		return $this->getEntityManager()
			->createQuery("SELECT COUNT(f.id) as cnt
                            FROM GazMainBundle:Finance f
                            LEFT JOIN f.terminal t
                            LEFT JOIN f.clientSale cs
							LEFT JOIN f.clientBuy cb
							WHERE t.number = :terminal AND f.financeType = FALSE
							                            ")
			->setParameter('terminal', $terminal)
			->getOneOrNullResult();
	}

	public function findNavData($date, $code)
	{
		return $this->getEntityManager()
			->createQuery('SELECT COUNT(f.id) as submited, SUM(f.price) as many,
									(SELECT COUNT(f1.id)
									FROM GazMainBundle:Finance f1
									WHERE f1.created >= :date AND f1.financeType = FALSE )  as failed,
									(SELECT SUM(f2.price)
									FROM GazMainBundle:Finance f2
									WHERE f2.created >= :date AND f2.financeType = FALSE )  as failedMany,
									(SELECT SUM(f3.price)
									FROM GazMainBundle:Finance f3
									LEFT JOIN f3.clientBuy cb
									WHERE f3.created >= :date AND f3.financeType = TRUE AND cb.paymentTypes = 2)  as cashMany,
									(SELECT cl.cashInfo FROM GazMainBundle:Client cl WHERE cl.code = :code) as cartMany
							FROM GazMainBundle:Finance f
							WHERE f.created >= :date AND f.financeType = TRUE
							')
			->setParameter('date', $date)
			->setParameter('code', $code)
			->getOneOrNullResult();
			;
	}

	public function findLastForRemove($terminal, $code)
	{
		return $this->getEntityManager()
			->createQuery('SELECT f FROM GazMainBundle:Finance f
						 	LEFT JOIN f.terminal t
						 	LEFT JOIN f.clientSale cs
							WHERE t.number = :terminal_number AND f.financeType = TRUE
							AND cs.code = :code AND f.created = (
												SELECT MAX (f1.created) FROM GazMainBundle:Finance f1
												LEFT JOIN f1.terminal t1
												LEFT JOIN f1.clientSale cs1
												WHERE t1.number = :terminal_number AND f1.financeType = TRUE
												AND cs1.code = :code )')
			->setParameters(array('terminal_number'=>$terminal, 'code'=>(string)$code))
			->getOneOrNullResult()
			;
	}

	public function findCash($from, $to)
	{
		return $this->getEntityManager()
			->createQuery('SELECT SUM(f.price) as cash
							FROM GazMainBundle:Finance f
							LEFT JOIN f.clientBuy cb
							WHERE f.created >= :from_date AND f.created <= :to_date
							AND f.financeType = TRUE
							')
			->setParameters(array('from_date'=>$from, 'to_date'=>$to))
			->getOneOrNullResult();
	}
}