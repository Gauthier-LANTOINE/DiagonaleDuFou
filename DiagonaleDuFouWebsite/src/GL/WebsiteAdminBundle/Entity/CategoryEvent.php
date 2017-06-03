<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategoryEvent
 *
 * @ORM\Table(name="category_event")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\CategoryEventRepository")
 */
class CategoryEvent
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
     * Libellé de la catégorie
     * 
     * @var string
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * 
     * @Assert\Length(max=25, maxMessage="La catégorie de l'événement au maximum 25 caractères")
     * @ORM\Column(name="name", type="string", length=25, unique=true)
     */
    private $name;


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
     * @return CategoryEvent
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
}

