<?php

namespace Gaz\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoginProvider
 *
 * @ORM\Table(name="login_provider")
 * @ORM\Entity(repositoryClass="Gaz\MainBundle\Entity\Repositories\LoginProviderRepositories")
 */
class LoginProvider
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
     * @ORM\Column(name="loginTime", type="datetime")
     */
    private $loginTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="logoutTime", type="datetime")
     */
    private $logoutTime;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Gaz\MainBundle\Entity\Client")
     * @ORM\JoinColumn(name="worker_id", referencedColumnName="id")
     */
    private $worker;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Gaz\MainBundle\Entity\Change")
     * @ORM\JoinColumn(name="change", referencedColumnName="id")
     */
    private $change;

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
     * Set loginTime
     *
     * @param \DateTime $loginTime
     * @return LoginProvider
     */
    public function setLoginTime($loginTime)
    {
        $this->loginTime = $loginTime;

        return $this;
    }

    /**
     * Get loginTime
     *
     * @return \DateTime 
     */
    public function getLoginTime()
    {
        return $this->loginTime;
    }

    /**
     * Set logoutTime
     *
     * @param \DateTime $logoutTime
     * @return LoginProvider
     */
    public function setLogoutTime($logoutTime)
    {
        $this->logoutTime = $logoutTime;

        return $this;
    }

    /**
     * Get logoutTime
     *
     * @return \DateTime 
     */
    public function getLogoutTime()
    {
        return $this->logoutTime;
    }

    /**
     * Set worker
     *
     * @param \Gaz\MainBundle\Entity\Client $worker
     * @return LoginProvider
     */
    public function setWorker(\Gaz\MainBundle\Entity\Client $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker
     *
     * @return \Gaz\MainBundle\Entity\Client 
     */
    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * Set change
     *
     * @param \Gaz\MainBundle\Entity\Change $change
     * @return LoginProvider
     */
    public function setChange(\Gaz\MainBundle\Entity\Change $change = null)
    {
        $this->change = $change;

        return $this;
    }

    /**
     * Get change
     *
     * @return \Gaz\MainBundle\Entity\Change 
     */
    public function getChange()
    {
        return $this->change;
    }
}
