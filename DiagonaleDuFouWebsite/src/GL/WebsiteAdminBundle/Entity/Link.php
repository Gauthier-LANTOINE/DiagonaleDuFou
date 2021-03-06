<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Link
 * Lien des Partenaires affiché en page d'accueil
 * 
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\LinkRepository")
 * 
 */
class Link
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
     * Libellé du lien
     * 
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(max=50, maxMessage="Le nom du lien doit faire au maximum 50 caractères")
     * 
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * URL du lien
     * @var string
     * 
     * @Assert\Url(
     *    message = "l'url '{{ value }}' n'est pas une url valide.",
     * )
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * Image du lien affiché
     * 
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    private $image;
    
    /**
     * Ordre d'affichage du lien
     * @var int
     * 
     * @Assert\Type("int")
     *
     * @ORM\Column(name="number_order", type="integer", nullable=false, unique=false)
     */
    private $order;


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
     * @return Link
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
     * Set url
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

   

    /**
     * Set image
     *
     * @param \GL\WebsiteAdminBundle\Entity\Image $image
     *
     * @return Link
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
     * Set order
     *
     * @param integer $order
     *
     * @return Link
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }
}
