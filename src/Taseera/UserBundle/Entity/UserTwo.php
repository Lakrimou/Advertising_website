<?php

namespace Taseera\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="user_two")
 * @UniqueEntity(fields = "username", targetClass = "Taseera\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Taseera\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class UserTwo extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TCountry")
     */
    private $tCountry;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TRegion")
     */
    private $tRegion;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TCity")
     */
    private $tCity;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TCityArea")
     */
    private $tCityArea;

    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;



    /**
     * @ORM\Column(name="phoneNumber", type="bigint", nullable=true)
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(name="facebook", type="string", nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(name="twitter", type="string", nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(name="googlePlus", type="string", nullable=true)
     */
    private $googlePlus;

    /**
     * Set tCountry
     *
     * @param \Taseera\BackendBundle\Entity\TCountry $tCountry
     *
     * @return UserTwo
     */
    public function setTCountry(\Taseera\BackendBundle\Entity\TCountry $tCountry = null)
    {
        $this->tCountry = $tCountry;

        return $this;
    }

    /**
     * Get tCountry
     *
     * @return \Taseera\BackendBundle\Entity\TCountry
     */
    public function getTCountry()
    {
        return $this->tCountry;
    }

    /**
     * Set tRegion
     *
     * @param \Taseera\BackendBundle\Entity\TRegion $tRegion
     *
     * @return UserTwo
     */
    public function setTRegion(\Taseera\BackendBundle\Entity\TRegion $tRegion = null)
    {
        $this->tRegion = $tRegion;

        return $this;
    }

    /**
     * Get tRegion
     *
     * @return \Taseera\BackendBundle\Entity\TRegion
     */
    public function getTRegion()
    {
        return $this->tRegion;
    }

    /**
     * Set tCity
     *
     * @param \Taseera\BackendBundle\Entity\TCity $tCity
     *
     * @return UserTwo
     */
    public function setTCity(\Taseera\BackendBundle\Entity\TCity $tCity = null)
    {
        $this->tCity = $tCity;

        return $this;
    }

    /**
     * Get tCity
     *
     * @return \Taseera\BackendBundle\Entity\TCity
     */
    public function getTCity()
    {
        return $this->tCity;
    }

    /**
     * Set tCityArea
     *
     * @param \Taseera\BackendBundle\Entity\TCityArea $tCityArea
     *
     * @return UserTwo
     */
    public function setTCityArea(\Taseera\BackendBundle\Entity\TCityArea $tCityArea = null)
    {
        $this->tCityArea = $tCityArea;

        return $this;
    }

    /**
     * Get tCityArea
     *
     * @return \Taseera\BackendBundle\Entity\TCityArea
     */
    public function getTCityArea()
    {
        return $this->tCityArea;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->addRole('ROLE_USER');
        /*$this->addGroup();*/
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return UserTwo
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     *
     * @return UserTwo
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return integer
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return UserTwo
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return UserTwo
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set googlePlus
     *
     * @param string $googlePlus
     *
     * @return UserTwo
     */
    public function setGooglePlus($googlePlus)
    {
        $this->googlePlus = $googlePlus;

        return $this;
    }

    /**
     * Get googlePlus
     *
     * @return string
     */
    public function getGooglePlus()
    {
        return $this->googlePlus;
    }
}
