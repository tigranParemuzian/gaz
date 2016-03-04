<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * ManyTransfer
 *
 * @ORM\Table(name="many_transfer")
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\ManyTransferRepositories")
 */
class ManyTransfer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"many_transfer"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     * @Groups({"many_transfer"})
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="cash", type="integer", nullable=false)
     * @Groups({"many_transfer"})
     */
    private $cash;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Gaz\MainBundle\Entity\Client")
     * @ORM\JoinColumn(name="sender", referencedColumnName="id", nullable=false)
     */
    private $sender;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Gaz\MainBundle\Entity\Client")
     * @ORM\JoinColumn(name="recipient", referencedColumnName="id", nullable=false)
     */
    private $recipient;

    /**
     * @var
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

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
     * Set created
     *
     * @param \DateTime $created
     * @return ManyTransfer
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
     * Set cash
     *
     * @param integer $cash
     * @return ManyTransfer
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
     * Set sender
     *
     * @param \Gaz\MainBundle\Entity\Client $sender
     * @return ManyTransfer
     */
    public function setSender(\Gaz\MainBundle\Entity\Client $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \Gaz\MainBundle\Entity\Client 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set recipient
     *
     * @param \Gaz\MainBundle\Entity\Client $recipient
     * @return ManyTransfer
     */
    public function setRecipient(\Gaz\MainBundle\Entity\Client $recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \Gaz\MainBundle\Entity\Client 
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}
