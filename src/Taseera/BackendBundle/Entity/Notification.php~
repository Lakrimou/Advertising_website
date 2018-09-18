<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="notification", type="text")
     */
    private $notification;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNotification", type="datetime")
     */
    private $dateNotification;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\UserBundle\Entity\UserOne")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userOne;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\UserBundle\Entity\UserTwo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userTwo;

    /**
     * @ORM\OneToOne(targetEntity="Taseera\BackendBundle\Entity\Messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $message;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set notification
     *
     * @param string $notification
     *
     * @return Notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get notification
     *
     * @return string
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     *
     * @return Notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return bool
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set dateNotification
     *
     * @param \DateTime $dateNotification
     *
     * @return Notification
     */
    public function setDateNotification($dateNotification)
    {
        $this->dateNotification = $dateNotification;

        return $this;
    }

    /**
     * Get dateNotification
     *
     * @return \DateTime
     */
    public function getDateNotification()
    {
        return $this->dateNotification;
    }

    /**
     * Set userOne
     *
     * @param \Taseera\UserBundle\Entity\UserOne $userOne
     *
     * @return Notification
     */
    public function setUserOne(\Taseera\UserBundle\Entity\UserOne $userOne)
    {
        $this->userOne = $userOne;

        return $this;
    }

    /**
     * Get userOne
     *
     * @return \Taseera\UserBundle\Entity\UserOne
     */
    public function getUserOne()
    {
        return $this->userOne;
    }

    /**
     * Set userTwo
     *
     * @param \Taseera\UserBundle\Entity\UserTwo $userTwo
     *
     * @return Notification
     */
    public function setUserTwo(\Taseera\UserBundle\Entity\UserTwo $userTwo)
    {
        $this->userTwo = $userTwo;

        return $this;
    }

    /**
     * Get userTwo
     *
     * @return \Taseera\UserBundle\Entity\UserTwo
     */
    public function getUserTwo()
    {
        return $this->userTwo;
    }

    /**
     * Set message
     *
     * @param \Taseera\BackendBundle\Entity\Messages $message
     *
     * @return Notification
     */
    public function setMessage(\Taseera\BackendBundle\Entity\Messages $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \Taseera\BackendBundle\Entity\Messages
     */
    public function getMessage()
    {
        return $this->message;
    }
}
