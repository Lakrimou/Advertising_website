<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\MessagesRepository")
 */
class Messages
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
     * @ORM\Column(name="subject", type="text", nullable=true)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publicationDate", type="datetime")
     */
    private $publicationDate;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Messages
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Messages
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     *
     * @return Messages
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set userOne
     *
     * @param \Taseera\UserBundle\Entity\UserOne $userOne
     *
     * @return Messages
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
     * @return Messages
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
}
