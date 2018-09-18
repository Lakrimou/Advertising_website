<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Item
 *
 * @ORM\Table(name="item", indexes={@ORM\Index(name="idx_b_premium", columns={"b_premium"}), @ORM\Index(name="idx_contact_email", columns={"contact_email"}), @ORM\Index(name="idx_date_pub", columns={"date_pub"}), @ORM\Index(name="idx_price", columns={"price"})})
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\ItemRepository")
 */
class Item
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
     * @ORM\Column(name="name_item", type="string", length=255)
     */
    private $nameItem;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pub", type="datetime")
     */
    private $datePub;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="datetime", nullable=true)
     */
    private $dateUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expiration", type="datetime")
     */
    private $dateExpiration;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_spam", type="boolean")
     */
    private $bSpam;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_active", type="boolean")
     */
    private $bActive;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_enabled", type="boolean")
     */
    private $bEnabled;

    /**
     * @var string
     *
     * @ORM\Column(name="s_ip", type="string", length=255)
     */
    private $sIp;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_show_email", type="boolean", nullable=true)
     */
    private $bShowEmail;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_premium", type="boolean")
     */
    private $bPremium;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=255, nullable=true)
     */
    private $contactName;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255, nullable=true)
     */
    private $contactEmail;

    /**
     * @ORM\ManyToMany(targetEntity="Taseera\BackendBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Taseera\BackendBundle\Entity\Media", cascade={"persist"})
     */
    private $medias;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\UserBundle\Entity\UserTwo", cascade={"persist"})
     */
    private $userTwo;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\UserBundle\Entity\UserOne", cascade={"persist"})
     */
    private $userOne;




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
     * Set nameItem
     *
     * @param string $nameItem
     *
     * @return Item
     */
    public function setNameItem($nameItem)
    {
        $this->nameItem = $nameItem;

        return $this;
    }

    /**
     * Get nameItem
     *
     * @return string
     */
    public function getNameItem()
    {
        return $this->nameItem;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Item
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

    /**
     * Set datePub
     *
     * @param \DateTime $datePub
     *
     * @return Item
     */
    public function setDatePub($datePub)
    {
        $this->datePub = $datePub;

        return $this;
    }

    /**
     * Get datePub
     *
     * @return \DateTime
     */
    public function getDatePub()
    {
        return $this->datePub;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     *
     * @return Item
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set dateExpiration
     *
     * @param \DateTime $dateExpiration
     *
     * @return Item
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * Get dateExpiration
     *
     * @return \DateTime
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * Set bSpam
     *
     * @param boolean $bSpam
     *
     * @return Item
     */
    public function setBSpam($bSpam)
    {
        $this->bSpam = $bSpam;

        return $this;
    }

    /**
     * Get bSpam
     *
     * @return bool
     */
    public function getBSpam()
    {
        return $this->bSpam;
    }

    /**
     * Set bActive
     *
     * @param boolean $bActive
     *
     * @return Item
     */
    public function setBActive($bActive)
    {
        $this->bActive = $bActive;

        return $this;
    }

    /**
     * Get bActive
     *
     * @return bool
     */
    public function getBActive()
    {
        return $this->bActive;
    }

    /**
     * Set bEnabled
     *
     * @param boolean $bEnabled
     *
     * @return Item
     */
    public function setBEnabled($bEnabled)
    {
        $this->bEnabled = $bEnabled;

        return $this;
    }

    /**
     * Get bEnabled
     *
     * @return bool
     */
    public function getBEnabled()
    {
        return $this->bEnabled;
    }

    /**
     * Set sIp
     *
     * @param string $sIp
     *
     * @return Item
     */
    public function setSIp($sIp)
    {
        $this->sIp = $sIp;

        return $this;
    }

    /**
     * Get sIp
     *
     * @return string
     */
    public function getSIp()
    {
        return $this->sIp;
    }

    /**
     * Set bShowEmail
     *
     * @param boolean $bShowEmail
     *
     * @return Item
     */
    public function setBShowEmail($bShowEmail)
    {
        $this->bShowEmail = $bShowEmail;

        return $this;
    }

    /**
     * Get bShowEmail
     *
     * @return bool
     */
    public function getBShowEmail()
    {
        return $this->bShowEmail;
    }

    /**
     * Set bPremium
     *
     * @param boolean $bPremium
     *
     * @return Item
     */
    public function setBPremium($bPremium)
    {
        $this->bPremium = $bPremium;

        return $this;
    }

    /**
     * Get bPremium
     *
     * @return bool
     */
    public function getBPremium()
    {
        return $this->bPremium;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     *
     * @return Item
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return Item
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \Taseera\BackendBundle\Entity\Category $category
     *
     * @return Item
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
     * Set userTwo
     *
     * @param \Taseera\UserBundle\Entity\UserTwo $userTwo
     *
     * @return Item
     */
    public function setUserTwo(\Taseera\UserBundle\Entity\UserTwo $userTwo = null)
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
     * Set userOne
     *
     * @param \Taseera\UserBundle\Entity\UserOne $userOne
     *
     * @return Item
     */
    public function setUserOne(\Taseera\UserBundle\Entity\UserOne $userOne = null)
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
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Set medias
     * @param \Taseera\BackendBundle\Entity\Media $medias
     */
    function setMedias($medias) {
        $this->medias = $medias;
    }

    /**
     * Add media
     *
     * @param \Taseera\BackendBundle\Entity\Media $media
     *
     * @return Item
     */
    public function addMedia(\Taseera\BackendBundle\Entity\Media $media)
    {
        $this->medias[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param \Taseera\BackendBundle\Entity\Media $media
     */
    public function removeMedia(\Taseera\BackendBundle\Entity\Media $media)
    {
        $this->medias->removeElement($media);
    }
}
