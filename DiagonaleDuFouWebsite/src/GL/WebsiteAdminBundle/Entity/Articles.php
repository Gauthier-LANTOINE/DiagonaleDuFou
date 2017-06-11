<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Articles
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\ArticlesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Articles {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Titre de l'article
     * 
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=80)
     * @Assert\Type("string")
     * @Assert\Length(min=5, minMessage="Le titre doit faire au moins 5 caractères")
     * @Assert\Length(max=80, maxMessage="Le titre doit faire au maximum 80 caractères")
     */
    private $title;

    /**
     * Sous-titre de l'article
     * 
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=200)
     * @Assert\Type("string")
     * @Assert\Length(min=10, minMessage="Le titre doit faire au moins 10 caractères")
     * @Assert\Length(max=200, maxMessage="Le titre doit faire au maximum 200 caractères")
     */
    private $subtitle;

    /**
     * Contenu de l'article
     * 
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\Type("string")
     * @Assert\Length(min=10, minMessage="Le contenu de l'article doit faire au moins 10 caractères")
     */
    private $content;

    /**
     * Valeur indiquant si l'article est publié
     * 
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     * @Assert\Type("bool")
     * @Assert\NotNull()
     */
    private $published;

    /**
     * Date de publication
     * 
     * @var \DateTime
     *
     * @ORM\Column(name="publication_date", type="datetime", nullable=true)
     * 
     * @Assert\DateTime()
     */
    private $publicationDate;

    /**
     * Date de dernière modification
     * 
     * @var \DateTime
     *
     * @ORM\Column(name="date_last_modified", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateLastModified;

    /**
     * Sous catégorie de l'article
     * 
     * @var SubCategoryArticle
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\SubCategoryArticle")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $subCategory;

    /**
     * Image associé à l'article
     * 
     * @var Image
     * 
     * @ORM\OneToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     * @Assert\Valid()
     */
    private $image;

    /**
     * slug de l'article
     * 
     * @var string
     * 
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
    
    /**
     * Membre ayant écrit l'article
     * 
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * 
     * @var Member 
     */
    private $member;

    public function __construct() {
        $this->published = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Articles
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Articles
     */
    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle() {
        return $this->subtitle;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Articles
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Articles
     */
    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     *
     * @return Articles
     */
    public function setPublicationDate($publicationDate) {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime
     */
    public function getPublicationDate() {
        return $this->publicationDate;
    }

    /**
     * Set dateLastModified
     *
     * @param \DateTime $dateLastModified
     *
     * @return Articles
     */
    public function setDateLastModified($dateLastModified) {
        $this->dateLastModified = $dateLastModified;

        return $this;
    }

    /**
     * Get dateLastModified
     *
     * @return \DateTime
     */
    public function getDateLastModified() {
        return $this->dateLastModified;
    }

    /**
     * Mise à jour de la date de dernière modification 
     * uniquement si l'article est publié
     * 
     * @ORM\PreUpdate
     */
    public function updateDateLastModified() {
        if ($this->published == TRUE) {
            $this->setDateLastModified(new \Datetime());
        }
    }

    /**
     * Set subCategory
     *
     * @param \GL\WebsiteAdminBundle\Entity\SubCategoryArticle $subCategory
     *
     * @return Articles
     */
    public function setSubCategory(\GL\WebsiteAdminBundle\Entity\SubCategoryArticle $subCategory) {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \GL\WebsiteAdminBundle\Entity\SubCategoryArticle
     */
    public function getSubCategory() {
        return $this->subCategory;
    }

    /**
     * Set image
     *
     * @param \GL\WebsiteAdminBundle\Entity\Image $image
     *
     * @return Articles
     */
    public function setImage(\GL\WebsiteAdminBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \GL\WebsiteAdminBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }


    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Articles
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
     * Set member
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $member
     *
     * @return Articles
     */
    public function setMember(\GL\WebsiteAdminBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \GL\WebsiteAdminBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
