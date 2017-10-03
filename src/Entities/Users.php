<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=5, nullable=true)
     */
    private $hash = '';

    /**
     * @var string
     *
     * @ORM\Column(name="real_name", type="text", length=255, nullable=true)
     */
    private $realName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=25, nullable=true)
     */
    private $city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=20, nullable=true)
     */
    private $province = '';

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=30, nullable=true)
     */
    private $country = '';

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=10, nullable=true)
     */
    private $zip = '';

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=40, nullable=true)
     */
    private $phone = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_total", type="integer", nullable=false)
     */
    private $feedbackTotal = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="feedback_count", type="integer", nullable=false)
     */
    private $feedbackCount = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="suspended", type="boolean", nullable=true)
     */
    private $suspended = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletter", type="boolean", nullable=false)
     */
    private $newsletter = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="balance", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $balance = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="payment_details", type="text", length=65535, nullable=true)
     */
    private $paymentDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="groups", type="text", length=65535, nullable=true)
     */
    private $groups;

    /**
     * @var boolean
     *
     * @ORM\Column(name="buynow_only_enabled", type="boolean", nullable=false)
     */
    private $buynowOnlyEnabled = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=50, nullable=false)
     */
    private $timezone = 'Europe/London';

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $language = '';

    /**
     * @var string
     *
     * @ORM\Column(name="remember_me", type="string", length=32, nullable=false)
     */
    private $rememberMe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @param string $realName
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getFeedbackTotal()
    {
        return $this->feedbackTotal;
    }

    /**
     * @param int $feedbackTotal
     */
    public function setFeedbackTotal($feedbackTotal)
    {
        $this->feedbackTotal = $feedbackTotal;
    }

    /**
     * @return int
     */
    public function getFeedbackCount()
    {
        return $this->feedbackCount;
    }

    /**
     * @param int $feedbackCount
     */
    public function setFeedbackCount($feedbackCount)
    {
        $this->feedbackCount = $feedbackCount;
    }

    /**
     * @return DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return bool
     */
    public function isSuspended()
    {
        return $this->suspended;
    }

    /**
     * @param bool $suspended
     */
    public function setSuspended($suspended)
    {
        $this->suspended = $suspended;
    }

    /**
     * @return bool
     */
    public function isNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param bool $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param string $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * @param string $paymentDetails
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * @return string
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param string $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return bool
     */
    public function isBuynowOnlyEnabled()
    {
        return $this->buynowOnlyEnabled;
    }

    /**
     * @param bool $buynowOnlyEnabled
     */
    public function setBuynowOnlyEnabled($buynowOnlyEnabled)
    {
        $this->buynowOnlyEnabled = $buynowOnlyEnabled;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getRememberMe()
    {
        return $this->rememberMe;
    }

    /**
     * @param string $rememberMe
     */
    public function setRememberMe($rememberMe)
    {
        $this->rememberMe = $rememberMe;
    }

    /**
     * @return DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param DateTime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}

