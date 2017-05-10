<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Image {

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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    
    /**
     * @Assert\Image(
     *     maxSize="1M",
     *     maxSizeMessage="Le fichier est trop volumineux, il ne doit pas dépasser {{ limit }} {{ suffix }}",
     *     mimeTypesMessage="Le fichier n'est pas une image valide."
     * )
     * 
     * @Vich\UploadableField(mapping="image", fileNameProperty="imageName", size="imageSize")
     * 
     * @var UploadedFile;
     */
    private $imageFile;
    
     /**
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(name="size", type="integer")
     *
     * @var integer
     */
    private $imageSize;
    
     /**
     * @ORM\Column(name="updated_date", type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }


    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Image
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageSize
     *
     * @param integer $imageSize
     *
     * @return Image
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get imageSize
     *
     * @return integer
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
     /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->url = __DIR__.'/../../../../web/img';
            $this->updatedAt = new \DateTimeImmutable();
            $this->imageSize =0;
        }
        
        return $this;
    }

    /**
     * 
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

}
