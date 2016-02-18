<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Change
 *
 * @ORM\Table(name="change")
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\ChangeRepositories")
 */
class Change
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
     * @var \DateTime
     *
     * @ORM\Column(name="open", type="datetime", nullable=false)
     */
    private $open;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended", type="datetime", nullable=true)
     */
    private $ended;

    /**
     * @var
     * @ORM\Column(name="cash", type="integer", options={"default":0})
     * @Groups({"many_transfer"})
     */
    private $cash;

    /**
     * @var float
     *
     * @ORM\Column(name="payment_percent", type="float", options={"default":0.01})
     * @Groups({"many_transfer"})
     */
    private $paymentPercent;

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
     * Set open
     *
     * @param \DateTime $open
     * @return Change
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return \DateTime 
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set ended
     *
     * @param \DateTime $ended
     * @return Change
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return \DateTime 
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set cash
     *
     * @param integer $cash
     * @return Change
     */
    public function setCash($cash)
    {
        $this->cash = $cash;

        return $this;
    }

    /**
     * Get cash
     *
     * @return integer 
     */
    public function getCash()
    {
        return $this->cash;
    }


    /**
     * Set paymentPercent
     *
     * @param float $paymentPercent
     * @return Settings
     */
    public function setPaymentPercent($paymentPercent)
    {
        $this->paymentPercent = $paymentPercent;

        return $this;
    }

    /**
     * Get paymentPercent
     *
     * @return float
     */
    public function getPaymentPercent()
    {
        return $this->paymentPercent;
    }
}
