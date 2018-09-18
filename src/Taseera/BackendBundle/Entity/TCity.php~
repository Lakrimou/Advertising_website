<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCity
 *
 * @ORM\Table(name="t_city", indexes={@ORM\Index(name="idx_s_name", columns={"s_name"}), @ORM\Index(name="idx_s_slug", columns={"s_slug"})})
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\TCityRepository")
 */
class TCity
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
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TRegion")
     */
    private $tRegion;

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
     * @return TCity
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
     * @return TCity
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
     * @return TCity
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
     * Set tRegion
     *
     * @param \Taseera\BackendBundle\Entity\TRegion $tRegion
     *
     * @return TCity
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
     * Set tCountry
     *
     * @param \Taseera\BackendBundle\Entity\TCountry $tCountry
     *
     * @return TCity
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
