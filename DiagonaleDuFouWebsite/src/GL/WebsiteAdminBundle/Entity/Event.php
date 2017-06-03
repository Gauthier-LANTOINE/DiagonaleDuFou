<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\EventRepository")
 */
class Event
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
     * Libellé de l'événement
     * 
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * 
     * @Assert\Length(max=60, maxMessage="L'intitulé de l'événement doit contenir au maximum 60 caractères")
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * Date à laquelle l'événement à lieu
     * 
     * @var \DateTime
     * @Assert\DateTime()
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    
    /**
     * Catégorie de l'événement
     * 
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="GL\WebsiteAdminBundle\Entity\CategoryEvent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


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
     * @return Event
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set category
     *
     * @param \GL\WebsiteAdminBundle\Entity\CategoryEvent $category
     *
     * @return Event
     */
    public function setCategory(\GL\WebsiteAdminBundle\Entity\CategoryEvent $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \GL\WebsiteAdminBundle\Entity\CategoryEvent
     */
    public function getCategory()
    {
        return $this->category;
    }
}
