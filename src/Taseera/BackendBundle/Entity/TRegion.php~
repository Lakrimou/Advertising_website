<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TRegion
 *
 * @ORM\Table(name="t_region", indexes={@ORM\Index(name="idx_s_name", columns={"s_name"}), @ORM\Index(name="idx_s_slug", columns={"s_slug"})})
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\TRegionRepository")
 */
class TRegion
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
     * @ORM\Column(name="s_name", type="string", length=255)
     */
    private $sName;

    /**
     * @var string
     *
     * @ORM\Column(name="s_slug", type="string", length=255)
     */
    private $sSlug;

    /**
     * @var bool
     *
     * @ORM\Column(name="b_active", type="boolean")
     */
    private $bActive;

    /**
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TCountry")
     */
    private $tCountry;

    public function __toString() {
        return $this->sName;
    }

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
     * Set sName
     *
     * @param string $sName
     *
     * @return TRegion
     */
    public function setSName($sName)
    {
        $this->sName = $sName;

        return $this;
    }

    /**
     * Get sName
     *
     * @return string
     */
    public function getSName()
    {
        return $this->sName;
    }

    /**
     * Set sSlug
     *
     * @param string $sSlug
     *
     * @return TRegion
     */
    public function setSSlug($sSlug)
    {
        $this->sSlug = $sSlug;

        return $this;
    }

    /**
     * Get sSlug
     *
     * @return string
     */
    public function getSSlug()
    {
        return $this->sSlug;
    }

    /**
     * Set bActive
     *
     * @param boolean $bActive
     *
     * @return TRegion
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
     * Set tCountry
     *
     * @param \Taseera\BackendBundle\Entity\TCountry $tCountry
     *
     * @return TRegion
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
}
