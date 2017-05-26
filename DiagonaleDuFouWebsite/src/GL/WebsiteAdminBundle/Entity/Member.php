<?php

namespace GL\WebsiteAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Member
 *
 * @ORM\Table(name="member")
 * @ORM\Entity(repositoryClass="GL\WebsiteAdminBundle\Repository\MemberRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Member {

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
     * @ORM\Column(name="email", type="string", length=254, nullable=true, unique=true)
     * @Assert\Email(
     *     message = "l'email '{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_home", type="string", length=12, nullable=true)
     * @Assert\Length(max=12, maxMessage="Le numéro de téléphone doit faire au maximum 12 caractères")
     */
    private $phoneHome;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=12, nullable=true)
     * @Assert\Length(max=12, maxMessage="Le numéro de téléphone doit faire au maximum 12 caractères")
     */
    private $mobilePhone;

    /**
     * @var bool
     *
     * @ORM\Column(name="allow_image_rights", type="boolean")
     */
    private $allowImageRights;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     *
     * @ORM\Column(name="registerDate", type="datetime", nullable=false)
     */
    private $registerDate;

    /**
     * @ORM\OneToOne(targetEntity="GL\UserBundle\Entity\User", inversedBy="member", cascade={"persist","remove"})
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Member
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
     * @return Member
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

    /**
     * Set birthDate
     *
     * @param Date $birthDate
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
     * @return Date
     */
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Member
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
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


    /**
     * Set user
     *
     * @param \GL\UserBundle\Entity\User $user
     *
     * @return Member
     */
    public function setUser(\GL\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GL\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
