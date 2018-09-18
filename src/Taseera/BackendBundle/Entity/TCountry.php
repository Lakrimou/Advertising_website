<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCountry
 *
 * @ORM\Table(name="t_country", indexes={@ORM\Index(name="idx_s_slug", columns={"s_slug"}), @ORM\Index(name="idx_s_name", columns={"s_name"})})
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\TCountryRepository")
 */
class TCountry
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
     * @ORM\Column(name="c_code", type="string", length=4)
     */
    private $cCode;

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
     * Set cCode
     *
     * @param string $cCode
     *
     * @return TCountry
     */
    public function setCCode($cCode)
    {
        $this->cCode = $cCode;

        return $this;
    }

    /**
     * Get cCode
     *
     * @return string
     */
    public function getCCode()
    {
        return $this->cCode;
    }

    /**
     * Set sName
     *
     * @param string $sName
     *
     * @return TCountry
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
     * @return TCountry
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
}
