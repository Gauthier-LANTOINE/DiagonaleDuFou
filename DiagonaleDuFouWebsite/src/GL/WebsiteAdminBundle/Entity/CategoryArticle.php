<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryArticle
 *
 * @ORM\Table(name="category_article")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\CategoryArticleRepository")
 */
class CategoryArticle
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;
    
    /**
     * @ORM\OneToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    private $image;


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
     * Set name
     *
     * @param string $name
     *
     * @return CategoryArticle
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param \GL\WebsiteAdminBundle\Entity\Image $image
     *
     * @return CategoryArticle
     */
    public function setImage(\GL\WebsiteAdminBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \GL\WebsiteAdminBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}