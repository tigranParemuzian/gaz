<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Terminal
 *
 * @ORM\Table(name="terminal")
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\TerminalRepositories")
 * @UniqueEntity(fields={"number"}, errorPath="title", message="number of terminal is duplicate")
 */
class Terminal
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
     * @ORM\Column(name="number", type="integer", unique=true, nullable=false)
     * @Groups({"terminal"})
     */
    private $number;

	/**
	 * @ORM\ManyToOne(targetEntity="Station", inversedBy="terminal")
	 * @ORM\JoinColumn(name="station_id", referencedColumnName="id", nullable=false)
	 */
	private $station;

	/**
	 * @ORM\OneToMany(targetEntity="Finance", mappedBy="terminal")
	 */
	private $finance;

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->getNumber();
	}
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->finance = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set number
     *
     * @param integer $number
     * @return Terminal
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set station
     *
     * @param \Gaz\MainBundle\Entity\Station $station
     * @return Terminal
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
     * Add finance
     *
     * @param \Gaz\MainBundle\Entity\Finance $finance
     * @return Terminal
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
}
