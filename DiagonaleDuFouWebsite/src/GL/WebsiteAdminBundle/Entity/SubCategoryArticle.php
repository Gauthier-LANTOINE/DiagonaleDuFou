<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SubCategoryArticle
 *
 * @ORM\Table(name="sub_category_article")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\SubCategoryArticleRepository")
 */
class SubCategoryArticle
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
     * Libellé de la sous catégorie
     * 
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(max=50, maxMessage="L'URL doit faire au maximum 50 caractères")
     * 
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;
    
    /**
     * Catégorie à laquelle la sous catégorie est lié
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\CategoryArticle", inversedBy="subCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
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
     * @return SubCategoryArticle
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
     * Set category
     *
     * @param \GL\WebsiteAdminBundle\Entity\CategoryArticle $category
     *
     * @return SubCategoryArticle
     */
    public function setCategory(\GL\WebsiteAdminBundle\Entity\CategoryArticle $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \GL\WebsiteAdminBundle\Entity\CategoryArticle
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return SubCategoryArticle
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
}
