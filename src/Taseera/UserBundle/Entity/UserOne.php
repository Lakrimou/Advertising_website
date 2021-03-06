<?php

namespace Taseera\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\UserInterface;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="user_one")
 * @UniqueEntity(fields = "username", targetClass = "Taseera\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Taseera\UserBundle\Entity\User", message="fos_user.email.already_used")
 * @ORM\Entity(repositoryClass="Taseera\UserBundle\Repository\UserOneRepository")
 */
class UserOne extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="accepted", nullable=true)
     */
    private $accepted;


    /**
     * @ORM\Column(type="bigint", name="phoneNumber", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="text", name="description", nullable=true)
     */
    private $description;

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
     * @ORM\ManyToMany(targetEntity="Taseera\BackendBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;

    /**
     * Set tCountry
     *
     * @param \Taseera\BackendBundle\Entity\TCountry $tCountry
     *
     * @return UserOne
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
     * @return UserOne
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
     * @return UserOne
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
     * @return UserOne
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

        $this->addRole('ROLE_COMPANY');
        $this->accepted = 0;
        /*$this->addGroup();*/
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return UserOne
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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->categories = new ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \Taseera\BackendBundle\Entity\Category $category
     *
     * @return UserOne
     */
    public function addCategory(\Taseera\BackendBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Taseera\BackendBundle\Entity\Category $category
     */
    public function removeCategory(\Taseera\BackendBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }


    /**
     * Set accepted
     *
     * @param integer $accepted
     *
     * @return UserOne
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return integer
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     *
     * @return UserOne
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
     * Set description
     *
     * @param string $description
     *
     * @return UserOne
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
