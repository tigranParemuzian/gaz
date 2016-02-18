<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Station
 *
 * @ORM\Table(name="station")
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\StationRepositories")
 * @UniqueEntity(fields={"code"}, errorPath="title", message="code is duplicate")
 */
class Station
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
     */
    private $number;

	/**
	 * @var
	 * @ORM\OneToMany(targetEntity="Terminal", mappedBy="station")
	 */
	private $terminal;

	/**
	 * @var
	 * @ORM\OneToMany(targetEntity="Finance", mappedBy="station")
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
     * @param string $number
     * @return Station
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->terminal = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add terminal
     *
     * @param \Gaz\MainBundle\Entity\Terminal $terminal
     * @return Station
     */
    public function addTerminal(\Gaz\MainBundle\Entity\Terminal $terminal)
    {
        $this->terminal[] = $terminal;

        return $this;
    }

    /**
     * Remove terminal
     *
     * @param \Gaz\MainBundle\Entity\Terminal $terminal
     */
    public function removeTerminal(\Gaz\MainBundle\Entity\Terminal $terminal)
    {
        $this->terminal->removeElement($terminal);
    }

    /**
     * Get terminal
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * Add finance
     *
     * @param \Gaz\MainBundle\Entity\Finance $finance
     * @return Station
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
