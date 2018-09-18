<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ViewsNumber
 *
 * @ORM\Table(name="views_number")
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\ViewsNumberRepository")
 */
class ViewsNumber
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
     * @ORM\Column(name="pageUrl", type="text", nullable=true)
     */
    private $pageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAdress", type="string", length=255, nullable=true)
     */
    private $ipAdress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAccess", type="datetime", nullable=true)
     */
    private $dateAccess;

    /**
     * @var int
     *
     * @ORM\Column(name="viewNbr", type="bigint", nullable=true)
     */
    private $viewNbr;

    /**
     * @var string
     *
     * @ORM\Column(name="emailUsername", type="string", length=255, nullable=true)
     */
    private $emailUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="userAgent", type="text", nullable=true)
     */
    private $userAgent;


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
     * Set pageUrl
     *
     * @param string $pageUrl
     *
     * @return ViewsNumber
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    /**
     * Get pageUrl
     *
     * @return string
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Set ipAdress
     *
     * @param string $ipAdress
     *
     * @return ViewsNumber
     */
    public function setIpAdress($ipAdress)
    {
        $this->ipAdress = $ipAdress;

        return $this;
    }

    /**
     * Get ipAdress
     *
     * @return string
     */
    public function getIpAdress()
    {
        return $this->ipAdress;
    }

    /**
     * Set dateAccess
     *
     * @param \DateTime $dateAccess
     *
     * @return ViewsNumber
     */
    public function setDateAccess($dateAccess)
    {
        $this->dateAccess = $dateAccess;

        return $this;
    }

    /**
     * Get dateAccess
     *
     * @return \DateTime
     */
    public function getDateAccess()
    {
        return $this->dateAccess;
    }

    /**
     * Set viewNbr
     *
     * @param integer $viewNbr
     *
     * @return ViewsNumber
     */
    public function setViewNbr($viewNbr)
    {
        $this->viewNbr = $viewNbr;

        return $this;
    }

    /**
     * Get viewNbr
     *
     * @return int
     */
    public function getViewNbr()
    {
        return $this->viewNbr;
    }

    /**
     * Set emailUsername
     *
     * @param string $emailUsername
     *
     * @return ViewsNumber
     */
    public function setEmailUsername($emailUsername)
    {
        $this->emailUsername = $emailUsername;

        return $this;
    }

    /**
     * Get emailUsername
     *
     * @return string
     */
    public function getEmailUsername()
    {
        return $this->emailUsername;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     *
     * @return ViewsNumber
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }
}
