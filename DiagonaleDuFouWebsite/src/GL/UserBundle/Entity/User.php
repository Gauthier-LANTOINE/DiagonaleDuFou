<?php

namespace GL\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="GL\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Cet email existe déjà.")
 * @UniqueEntity(fields="username", message="Ce login existe déjà.")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     *
     * @ORM\Column(name="registerDate", type="datetime", nullable=false)
     */
    private $registerDate;
    
    /**
   * @ORM\OneToOne(targetEntity="GL\WebsiteAdminBundle\Entity\Member", mappedBy="user")
   */
  private $member;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->addRole("ROLE_USER");
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    //Force la désactivation du compte par défaut afin de pouvoir valider manuellement
    //avec l'interface administrateur
    /**
     * @ORM\PrePersist
     */
    public function setDisabledByDefault() {
        $this->setEnabled(false);
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return User
     */
    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate() {
        return $this->registerDate;
    }

    /**
     * @ORM\PrePersist
     */
    public function addRegisterDate() {
        $this->setRegisterDate(new \Datetime());
    }

    //copie l'adresse Email comme Pseudo pour l'identification
    public function setEmail($email) {
        parent::setEmail($email);
        $this->setUsername($email);
    }


    /**
     * Set member
     *
     * @param \GL\WebsiteAdminBundle\Entity\Member $member
     *
     * @return User
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
