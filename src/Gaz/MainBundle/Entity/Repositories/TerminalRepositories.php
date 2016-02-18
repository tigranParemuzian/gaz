<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/25/15
 * Time: 6:12 PM
 */
namespace Gaz\MainBundle\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

class TerminalRepositories extends EntityRepository
{

	/**
	 * @return array
	 */
	public function findTerminals()
	{
		return $this->getEntityManager()
			->createQuery("SELECT t.number as id
							FROM GazMainBundle:Terminal t
							INNER JOIN t.finance f
							WHERE f.id IS NOT NULL
							GROUP BY t.number
							ORDER BY t.number")
			->getArrayResult()
		;
	}

	/**
	 * This repository find data for terminal list
	 * @return array
	 */
	public function findAllForList()
	{
		return $this ->getEntityManager()
			->createQuery('SELECT t.id as id, t.number as number, s.number as station FROM GazMainBundle:Terminal t
							LEFT JOIN t.station s
							ORDER BY t.number ASC
						')->getArrayResult()
			;
	}

    /**
     * This repository find Last crated data for worker
     * @return array
     */
    public function findDataLast()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT DISTINCT t.number, f.id as finance, f.price as cost, f.gotcarq as gotcarqId
                            FROM GazMainBundle:Terminal t
                            JOIN GazMainBundle:Finance f WITH f.terminal = t
							WHERE (f.gotcarq IS NOT NULL AND f.gotcarq != 0)
							  AND f.created = (SELECT MIN(f1.created) FROM GazMainBundle:Finance f1
                                LEFT JOIN f1.terminal t1
                                WHERE t1.id = t.id AND f1.financeType = FALSE)
							ORDER BY t.number ASC
                            ")
            ->getResult();
    }

	/**
     * This repository find Last crated data for worker
     * @return array
     */
    public function findDataLastByTermianl($terminal)
    {


		return $this->getEntityManager()
            ->createQuery("SELECT DISTINCT t.number, f.id as finance, f.price as cost, f.gotcarq as gotcarqId
                            FROM GazMainBundle:Terminal t
                            JOIN GazMainBundle:Finance f WITH f.terminal = t
							WHERE (f.gotcarq IS NOT NULL AND f.gotcarq != 0) AND f.financeType = FALSE
							  AND f.created = (SELECT MIN(f1.created) FROM GazMainBundle:Finance f1
                                LEFT JOIN f1.terminal t1
                                WHERE t1.id = t.id AND f1.financeType = FALSE)
							AND t.number = :terminal
                            ")
				->setParameter('terminal', $terminal)
            ->getOneOrNullResult();
    }

	/**
     * This repository find Last crated data for worker
     * @return array
     */
    public function findCount()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT t.number, COUNT(f.id) as cnt
                            FROM GazMainBundle:Finance f
                            LEFT JOIN f.terminal t
                            LEFT JOIN f.clientSale cs
							LEFT JOIN f.clientBuy cb
							WHERE f.financeType = FALSE
							GROUP BY t.number
							ORDER BY t.number ASC
                            ")
            ->getResult();
    }

	public function findNumbers()
	{
		return $this->getEntityManager()
			->createQuery("SELECT t
                            FROM GazMainBundle:Terminal t
							WHERE t.number IS NOT NULL
							ORDER BY t.number ASC
                            ")
			->getResult();
	}
}