<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 */
class Settings
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
     * @var float
     *
     * @ORM\Column(name="payment_percent", type="float")
     */
    private $paymentPercent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="percent_transfer", type="datetime")
     */
    private $percentTransfer;


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

    /**
     * Set percentTransfer
     *
     * @param \DateTime $percentTransfer
     * @return Settings
     */
    public function setPercentTransfer($percentTransfer)
    {
        $this->percentTransfer = $percentTransfer;

        return $this;
    }

    /**
     * Get percentTransfer
     *
     * @return \DateTime 
     */
    public function getPercentTransfer()
    {
        return $this->percentTransfer;
    }
}
