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
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     * 
     * @Assert\Length(min=2, minMessage="Le prénom doit faire au moins 2 caractères")
     * @Assert\Length(max=50, maxMessage="Le prénom doit faire au maximum 50 caractères")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     * 
     * @Assert\Length(min=2, minMessage="Le titre doit faire au moins 5 caractères")
     * @Assert\Length(max=50, maxMessage="Le titre doit faire au maximum 50 caractères")
     */
    private $lastName;

    /**
     * @var \DateTime
     * @Assert\Date()
     * @ORM\Column(name="birth_date", type="date", nullable=false)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_home", type="string", length=12, nullable=true)
     * @Assert\Length(max=12, maxMessage="Le numéro doit faire au maximum 12 caractères")
     */
    private $phoneHome;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=12, nullable=true)
     * @Assert\Length(max=12, maxMessage="Le numéro doit faire au maximum 12 caractères")
     */
    private $mobilePhone;

    /**
     * @var bool
     *
     * @ORM\Column(name="allow_image_rights", type="boolean", nullable=false)
     */
    private $allowImageRights;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     *
     * @ORM\Column(name="registerDate", type="datetime", nullable=false)
     */
    private $registerDate;
    
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

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Member
     */
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * Set phoneHome
     *
     * @param string $phoneHome
     *
     * @return Member
     */
    public function setPhoneHome($phoneHome) {
        $this->phoneHome = $phoneHome;

        return $this;
    }

    /**
     * Get phoneHome
     *
     * @return string
     */
    public function getPhoneHome() {
        return $this->phoneHome;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     *
     * @return Member
     */
    public function setMobilePhone($mobilePhone) {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone() {
        return $this->mobilePhone;
    }

    /**
     * Set allowImageRights
     *
     * @param boolean $allowImageRights
     *
     * @return Member
     */
    public function setAllowImageRights($allowImageRights) {
        $this->allowImageRights = $allowImageRights;

        return $this;
    }

    /**
     * Get allowImageRights
     *
     * @return bool
     */
    public function getAllowImageRights() {
        return $this->allowImageRights;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
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

}
