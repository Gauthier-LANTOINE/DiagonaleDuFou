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
     * Prénom du membre
     * 
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     * 
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Le prénom doit faire au moins 2 caractères")
     * @Assert\Length(max=50, maxMessage="Le prénom doit faire au maximum 50 caractères")
     */
    private $firstName;

    /**
     * Nom du Membre
     * 
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     * 
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Le titre doit faire au moins 2 caractères")
     * @Assert\Length(max=50, maxMessage="Le titre doit faire au maximum 50 caractères")
     */
    private $lastName;

    /**
     * Date de naissance
     * 
     * @var \DateTime
     * @Assert\Date()
     * @ORM\Column(name="birth_date", type="date", nullable=false)
     */
    private $birthDate;

    /**
     * Email du membre
     * 
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
     * Numéro de téléphone fixe
     * 
     * @var string
     * 
     * @Assert\Type("string")
     * @ORM\Column(name="phone_home", type="string", length=12, nullable=true)
     * @Assert\Length(max=12, maxMessage="Le numéro de téléphone doit faire au maximum 12 caractères")
     */
    private $phoneHome;

    /**
     * Numéro de téléphone portable
     * 
     * @var string
     *
     * @Assert\Type("string")
     * @ORM\Column(name="mobile_phone", type="string", length=12, nullable=true)
     * @Assert\Length(max=12, maxMessage="Le numéro de téléphone doit faire au maximum 12 caractères")
     */
    private $mobilePhone;

    /**
     * Droit d'utiliser l'image du membre
     * 
     * @var bool
     * @Assert\Type("bool")
     * @ORM\Column(name="allow_image_rights", type="boolean")
     */
    private $allowImageRights;

    /**
     * Date d'enregistrement
     * 
     * @var \DateTime
     * @Assert\DateTime()
     *
     * @ORM\Column(name="registerDate", type="datetime", nullable=false)
     */
    private $registerDate;
    
    /**
     * Numéro de license FFE
     * 
     * @Assert\Length(min=6, minMessage="Le numéro de licence doit faire au moins 6 caractères")
     * @Assert\Length(max=6, maxMessage="Le numéro de licence doit faire au maximum 6 caractères")
     * @ORM\Column(name="num_licence", type="string", length=6, nullable=true)
     * @var string
     */
    private $numLicence;
    
    /**
     * Numéro de la voie
     * 
     * @Assert\Type(
     *     type="integer",
     *     message="La valeur {{ value }} n'est pas du type {{ type }}."
     * )
     * @ORM\Column(name="way_number", type="integer", nullable=true)
     * @var int 
     */
    private $wayNumber;
    /**
     * Libellé de la voie
     * 
     * @Assert\Regex("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,100})$/")
     * @Assert\Length(min=2, minMessage="La voie doit faire au moins 2 caractères")
     * @Assert\Length(max=100, maxMessage="La voie ne peut pas faire plus de 100 caractères")
     * @ORM\Column(name="voie", type="string", length=100, nullable=true)
     * @var string
     */
    private $way;
    
    /**
     * Complément d'adresse
     *
     * @ORM\Column(name="additional_address", type="string", length=100, nullable=true)
     * @var string
     */
    private $additionalAddress;

    /**
     * Nom de la ville
     * 
     * @Assert\Regex("/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,50})$/")
     * @Assert\Length(min=2, minMessage="La ville doit faire au moins 2 caractères")
     * @Assert\Length(max=50, maxMessage="La ville ne peut pas faire plus de 50 caractères")
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     * @var type 
     */
    private $city;
    
     /**
     * Code Postal
     * @Assert\Regex("/^[0-9]{4,5}$/")
     * 
     * @ORM\Column(name="postal_code", type="string", length=5, nullable=true)
     * @var type 
     */
    private $postalCode;
    
    /**
     * Pays
     * 
     * @Assert\Choice({"France", "Belgique"}, message = "Choisissez un pays valide")
     * @ORM\Column(name="country", type="string", length=8, nullable=true)
     * @var type 
     */
    private $country;

    /**
     * Compte utilisateur lié au membre
     * 
     * @Assert\Valid()
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

    /**
     * Set numLicence
     *
     * @param string $numLicence
     *
     * @return Member
     */
    public function setNumLicence($numLicence)
    {
        $this->numLicence = $numLicence;

        return $this;
    }

    /**
     * Get numLicence
     *
     * @return string
     */
    public function getNumLicence()
    {
        return $this->numLicence;
    }

    /**
     * Set wayNumber
     *
     * @param integer $wayNumber
     *
     * @return Member
     */
    public function setWayNumber($wayNumber)
    {
        $this->wayNumber = $wayNumber;

        return $this;
    }

    /**
     * Get wayNumber
     *
     * @return integer
     */
    public function getWayNumber()
    {
        return $this->wayNumber;
    }

    /**
     * Set way
     *
     * @param string $way
     *
     * @return Member
     */
    public function setWay($way)
    {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return string
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set additionalAddress
     *
     * @param string $additionalAddress
     *
     * @return Member
     */
    public function setAdditionalAddress($additionalAddress)
    {
        $this->additionalAddress = $additionalAddress;

        return $this;
    }

    /**
     * Get additionalAddress
     *
     * @return string
     */
    public function getAdditionalAddress()
    {
        return $this->additionalAddress;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Member
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Member
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Member
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
