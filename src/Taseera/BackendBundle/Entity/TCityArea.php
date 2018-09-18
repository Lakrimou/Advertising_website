<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCityArea
 *
 * @ORM\Table(name="t_city_area", indexes={@ORM\Index(name="idx_s_name", columns={"s_name"})})
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\TCityAreaRepository")
 */
class TCityArea
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
     * @ORM\ManyToOne(targetEntity="Taseera\BackendBundle\Entity\TCity")
     */
    private $tCity;

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
     * @return TCityArea
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
     * Set tCity
     *
     * @param \Taseera\BackendBundle\Entity\TCity $tCity
     *
     * @return TCityArea
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
}
