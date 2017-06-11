<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * Libellé de la catégorie d'article
     * 
     * @var string
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(max=50, maxMessage="Le nom de la catégorie doit faire au maximum 50 caractères")
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;
    
    /**
     * slug de la catégorie
     * 
     * @var string
     * 
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
    
    /**
     * Objet image lié à la catégorie (image par défaut)
     * 
     * @var Image
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     */
    private $image;
    
    /**
     * Sous catégorie des articles
     * 
     * @ORM\OneToMany(targetEntity="GL\WebsiteAdminBundle\Entity\SubCategoryArticle", mappedBy="category")
     * @var SubCategoryArticle
     */
    private $subCategories;


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

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CategoryArticle
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
    }

    /**
     * Add subCategory
     *
     * @param \GLWebsiteAdminBundle\Entity\SubCategoryArticle $subCategory
     *
     * @return CategoryArticle
     */
    public function addSubCategory(\GL\WebsiteAdminBundle\Entity\SubCategoryArticle $subCategory)
    {
        $this->subCategories[] = $subCategory;

        return $this;
    }

    /**
     * Remove subCategory
     *
     * @param \GLWebsiteAdminBundle\Entity\SubCategoryArticle $subCategory
     */
    public function removeSubCategory(\GL\WebsiteAdminBundle\Entity\SubCategoryArticle $subCategory)
    {
        $this->subCategories->removeElement($subCategory);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }
}
