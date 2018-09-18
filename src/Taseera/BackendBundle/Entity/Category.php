<?php

namespace Taseera\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Taseera\BackendBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="nameCategory", type="string", length=255)
     */
    private $nameCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * One Student has One Student.
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="subCategory_id", referencedColumnName="id")
     */
    private $subCategory;

    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(name="coverPic", type="string", nullable=true)
     */
    private $coverPicture;


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
     * Set nameCategory
     *
     * @param string $nameCategory
     *
     * @return Category
     */
    public function setNameCategory($nameCategory)
    {
        $this->nameCategory = $nameCategory;

        return $this;
    }

    /**
     * Get nameCategory
     *
     * @return string
     */
    public function getNameCategory()
    {
        return $this->nameCategory;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
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
     * Set image
     *
     * @param string $image
     *
     * @return Category
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
     * Set subCategory
     *
     * @param \Taseera\BackendBundle\Entity\Category $subCategory
     *
     * @return Category
     */
    public function setSubCategory(\Taseera\BackendBundle\Entity\Category $subCategory = null)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \Taseera\BackendBundle\Entity\Category
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Set coverPicture
     *
     * @param string $coverPicture
     *
     * @return Category
     */
    public function setCoverPicture($coverPicture)
    {
        $this->coverPicture = $coverPicture;

        return $this;
    }

    /**
     * Get coverPicture
     *
     * @return string
     */
    public function getCoverPicture()
    {
        return $this->coverPicture;
    }
}
