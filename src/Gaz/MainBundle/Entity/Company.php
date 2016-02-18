<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\CompanyRepositories")
 * @UniqueEntity(fields={"name"}, errorPath="name", message="Company name can`not be duplicated")
 */
class Company
{
	const FREE = 0;
	const TRANSFER = 1;
	const CASH = 2;

	const WORKER = 3;
	const COMPANY = 4;
	const CITIZEN = 5;
	const DIRECTOR = 6;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
	 * @Groups({"client"})
     */
    private $name;

	/**
	 * @var integer
	 * @Assert\NotBlank()
	 * @Assert\Length(min=10, max=10)
	 * @ORM\Column(name="code", type="string", length=10, nullable=false,  unique=true)
	 */
	private $code;
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="payment_types", type="smallint", length=3, nullable=false)
	 * @Groups({"client"})
	 */
	private $paymentTypes = self::CASH;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="group_type", type="smallint", length=3, nullable=false)
	 */
	private $groupType = self::COMPANY;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="percent", type="float", nullable=true)
	 */
	private $percent;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="deposit_limit", type="integer", nullable=true)
	 */
	private $depositLimit;

	/**
	 * @ORM\OneToMany(targetEntity="Client", mappedBy="company")
	 */
	private $client;

	/**
	 * @return string
	 */
	public function __toString()
	{
		if($this->getGroupType() == 6)
		{
			return (string)$this->getName(). ' director ';
		}
		elseif($this->getGroupType() == 3)
		{
			return (string)$this->getName(). ' worker ';
		}
		elseif($this->getGroupType() == 4)
		{
			return (string)$this->getName(). ' company ';
		}
		elseif($this->getGroupType() == 5)
		{
			return (string)$this->getName(). ' citizen ';
		}
		else
		{
			throw new NotFoundHttpException('not fount type');
		}

	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->finance = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add finance
     *
     * @param \Gaz\MainBundle\Entity\Finance $finance
     * @return Company
     */
    public function addFinance(\Gaz\MainBundle\Entity\Finance $finance)
    {
        $this->finance[] = $finance;

        return $this;
    }

    /**
     * Remove finance
     *
     * @param \Gaz\MainBundle\Entity\Finance $finance
     */
    public function removeFinance(\Gaz\MainBundle\Entity\Finance $finance)
    {
        $this->finance->removeElement($finance);
    }

    /**
     * Get finance
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFinance()
    {
        return $this->finance;
    }

	/**
	 * Set paymentTypes
	 *
	 * @param $paymentTypes
	 * @return $this
	 * @throws \Exception
	 */
	public function setPaymentTypes($paymentTypes)
	{
		if ($paymentTypes == self::CASH 	||
			$paymentTypes == self::TRANSFER ||
			$paymentTypes == self::FREE )
		{
			$this->paymentTypes = $paymentTypes;
		}
		else
		{
			throw new \Exception('PaymentTypes value for Finanse status');
		}

		$this->paymentTypes = $paymentTypes;

		return $this;
	}

	/**
	 * Get paymentTypes
	 *
	 * @return integer
	 */
	public function getPaymentTypes()
	{
		return $this->paymentTypes;
	}

	/**
	 * Set groupType
	 *
	 * @param $groupType
	 * @return $this
	 * @throws \Exception
	 */
	public function setGroupType($groupType)
	{
		if ($groupType == self::CITIZEN 	||
			$groupType == self::COMPANY ||
			$groupType == self::DIRECTOR ||
			$groupType == self::WORKER  )
		{
			$this->groupType = $groupType;
		}
		else
		{
			throw new \Exception('GroupType value for Company status');
		}

		$this->groupType = $groupType;

		return $this;
	}

	/**
	 * Get groupType
	 *
	 * @return integer
	 */
	public function getGroupType()
	{
		return $this->groupType;
	}

    /**
     * Set percent
     *
     * @param float $percent
     * @return Company
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return float 
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set depositLimit
     *
     * @param integer $depositLimit
     * @return Company
     */
    public function setDepositLimit($depositLimit)
    {
        $this->depositLimit = $depositLimit;

        return $this;
    }

    /**
     * Get depositLimit
     *
     * @return integer 
     */
    public function getDepositLimit()
    {
        return $this->depositLimit;
    }

    /**
     * Add client
     *
     * @param \Gaz\MainBundle\Entity\Client $client
     * @return Company
     */
    public function addClient(\Gaz\MainBundle\Entity\Client $client)
    {
        $this->client[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \Gaz\MainBundle\Entity\Client $client
     */
    public function removeClient(\Gaz\MainBundle\Entity\Client $client)
    {
        $this->client->removeElement($client);
    }

    /**
     * Get client
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set code
     *
     * @param integer $code
     * @return Company
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }
}
