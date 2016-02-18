<?php

namespace Gaz\MainBundle\Entity;

use APY\DataGridBundle\Grid\Mapping\Column;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Finance
 *
 * @ORM\Table(name="finance", indexes={
 *                  @ORM\Index(name="gotcarq", columns={"gotcarq"}),
 *                  @ORM\Index(name="created_index", columns={"created"}),
 *                  @ORM\Index(name="finance_type_index", columns={"finance_type"})
 *                                      })
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\FinanceRepositories")
 */
class Finance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="price", type="smallint", nullable=true)
	 */
	private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="balance", type="smallint", nullable=true)
     */
    private $balance;

    /**
     * @var float
     *
     * @ORM\Column(name="deposit", type="float", nullable=true)
     */
    private $deposit;

	/**
     * @var integer
     *
     * @ORM\Column(name="residue", type="smallint", nullable=true)
     */
    private $residue;

	/**
     * @var integer
     *
     * @ORM\Column(name="gotcarq", type="integer", nullable=false, options={"default":"00000000"})
     */
    private $gotcarq;

    /**
     * @var bool
     * @ORM\Column(name="finance_type", type="boolean", options={"default":0})
     */
    private $financeType = false;

	/**
	 * @var datetime $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $created;

	/**
	 * @ORM\ManyToOne(targetEntity="Client", inversedBy="financeSale")
	 * @ORM\JoinColumn(name="client_sale_id", referencedColumnName="id", nullable=true)
	 */
	private $clientSale;

	/**
	 * @ORM\ManyToOne(targetEntity="Client", inversedBy="financeBuy")
	 * @ORM\JoinColumn(name="client_buy_id", referencedColumnName="id", nullable=true)
	 */
	private $clientBuy;

	/**
	 * @ORM\ManyToOne(targetEntity="Terminal", inversedBy="finance")
	 * @ORM\JoinColumn(name="terminal_id", referencedColumnName="id", nullable=false)
	 */
	private $terminal;

	/**
	 * @ORM\ManyToOne(targetEntity="Station", inversedBy="finance")
	 * @ORM\JoinColumn(name="station_id", referencedColumnName="id", nullable=false)
	 */
	private $station;

    public function __toString()
    {
        return ($this->id) ? (string)$this->id : 'New CR Info';
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
     * Set balance
     *
     * @param float $balance
     * @return Finance
     */
    public function setBalance($balance)
    {

		if($balance != null) {
			$this->balance = $this->getBalance() + $balance;
		}

		return $this;
    }

    /**
     * Get balance
     *
     * @return float 
     */
    public function getBalance()
    {
        return $this->balance;
    }


    /**
     * Set deposit
     *
     * @param float $deposit
     * @return Finance
     */
    public function setDeposit($deposit)
    {
		if($deposit != null) {
			$this->deposit = $deposit;
		}

        return $this;
    }

    /**
     * Get deposit
     *
     * @return float 
     */
    public function getDeposit()
    {
        return $this->deposit;
    }
	
    /**
     * Set terminal
     *
     * @param \Gaz\MainBundle\Entity\Terminal $terminal
     * @return Finance
     */
    public function setTerminal(\Gaz\MainBundle\Entity\Terminal $terminal)
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * Get terminal
     *
     * @return \Gaz\MainBundle\Entity\Terminal 
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * Set station
     *
     * @param \Gaz\MainBundle\Entity\Station $station
     * @return Finance
     */
    public function setStation(\Gaz\MainBundle\Entity\Station $station)
    {
        $this->station = $station;

        return $this;
    }

    /**
     * Get station
     *
     * @return \Gaz\MainBundle\Entity\Station 
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set residue
     *
     * @param float $residue
     * @return Finance
     */
    public function setResidue($residue)
    {
        $this->residue = $residue;

        return $this;
    }

    /**
     * Get residue
     *
     * @return float 
     */
    public function getResidue()
    {
        return $this->residue;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Finance
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Finance
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set clientSale
     *
     * @param \Gaz\MainBundle\Entity\Client $clientSale
     * @return Finance
     */
    public function setClientSale(\Gaz\MainBundle\Entity\Client $clientSale)
    {
        $this->clientSale = $clientSale;

        return $this;
    }

    /**
     * Get clientSale
     *
     * @return \Gaz\MainBundle\Entity\Client 
     */
    public function getClientSale()
    {
        return $this->clientSale;
    }

    /**
     * Set clientBuy
     *
     * @param \Gaz\MainBundle\Entity\Client $clientBuy
     * @return Finance
     */
    public function setClientBuy(\Gaz\MainBundle\Entity\Client $clientBuy)
    {
        $this->clientBuy = $clientBuy;

        return $this;
    }

    /**
     * Get clientBuy
     *
     * @return \Gaz\MainBundle\Entity\Client 
     */
    public function getClientBuy()
    {
        return $this->clientBuy;
    }

    /**
     * Set gotcarq
     *
     * @param integer $gotcarq
     * @return Finance
     */
    public function setGotcarq($gotcarq)
    {
        $this->gotcarq = $gotcarq;

        return $this;
    }

    /**
     * Get gotcarq
     *
     * @return integer 
     */
    public function getGotcarq()
    {
        return $this->gotcarq;
    }

    /**
     * @return boolean
     */
    public function getFinanceType()
    {
        return $this->financeType;
    }

    /**
     * @param boolean $financeType
     */
    public function setFinanceType($financeType)
    {
        $this->financeType = $financeType;
    }
}
