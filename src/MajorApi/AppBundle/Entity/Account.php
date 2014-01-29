<?php

namespace MajorApi\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Security\Core\User\UserInterface;

use \DateTime,
    \Serializable;

class Account extends \Brightmarch\RestEasy\Entity\Entity
    implements UserInterface, Serializable
{

    /** @var integer */
    protected $id;

    /** @var DateTime */
    protected $created;

    /** @var DateTime */
    protected $updated;

    /** @var integer */
    protected $status = 0;

    /** @var string */
    protected $email;

    /** @var string */
    protected $salt = '';

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $role;

    /** @var string */
    protected $billingToken;

    /** @var string */
    protected $billingDigits;

    /** @var string */
    protected $billingType;

    /** @var float */
    protected $planAmount = 0.0;

    /** @var float */
    protected $transactionRate = 0.0;

    /** @var string */
    protected $stripeAccessToken;

    /** @var string */
    protected $stripeRefreshToken;

    /** @var string */
    protected $stripePublishableKey;

    /** @var string */
    protected $stripeUserId;

    /** @var Doctrine\Common\Collections\ArrayCollection */
    protected $applications;

    /** @const string */
    const ROLE = 'ROLE_ACCOUNT';

    public function __construct()
    {
        $this->applications = new ArrayCollection;
    }

    public function onCreate()
    {
        $this->setCreated(new DateTime)
            ->setUpdated(new DateTime)
            ->setRole(self::ROLE)
            ->enable();

        return true;
    }
    
    public function onUpdate()
    {
        $this->setUpdated(new DateTime);

        return true;
    }

    public function isConnectedToStripe()
    {
        $hasStripeAccessToken = !empty($this->stripeAccessToken);
        $hasStripeUserId = !empty($this->stripeUserId);

        return ($hasStripeAccessToken && $hasStripeUserId);
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->passwordHash;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [$this->role];
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        return false;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize([$this->id]);
    }

    /**
     * @see \Serializable::serialize()
     */
    public function unserialize($serialized)
    {
        list($this->id) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Account
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Account
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Account
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = strtolower($email);
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Account
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     * @return Account
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    
        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string 
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Account
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Account
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Account
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set billingToken
     *
     * @param string $billingToken
     * @return Account
     */
    public function setBillingToken($billingToken)
    {
        $this->billingToken = $billingToken;
    
        return $this;
    }

    /**
     * Get billingToken
     *
     * @return string 
     */
    public function getBillingToken()
    {
        return $this->billingToken;
    }

    /**
     * Has billingToken
     *
     * @return boolean
     */
    public function hasCreditCard()
    {
        return (!empty($this->billingToken));
    }

    /**
     * Set billingDigits
     *
     * @param string $billingDigits
     * @return Account
     */
    public function setBillingDigits($billingDigits)
    {
        $this->billingDigits = $billingDigits;
    
        return $this;
    }

    /**
     * Get billingDigits
     *
     * @return string 
     */
    public function getBillingDigits()
    {
        return $this->billingDigits;
    }

    /**
     * Set billingType
     *
     * @param string $billingType
     * @return Account
     */
    public function setBillingType($billingType)
    {
        $this->billingType = $billingType;
    
        return $this;
    }

    /**
     * Get billingType
     *
     * @return string 
     */
    public function getBillingType()
    {
        return $this->billingType;
    }

    /**
     * Set planAmount
     *
     * @param float $planAmount
     * @return Account
     */
    public function setPlanAmount($planAmount)
    {
        $this->planAmount = (float)$planAmount;
    
        return $this;
    }

    /**
     * Get planAmount
     *
     * @return float 
     */
    public function getPlanAmount()
    {
        return $this->planAmount;
    }

    /**
     * Set transactionRate
     *
     * @param float $transactionRate
     * @return Account
     */
    public function setTransactionRate($transactionRate)
    {
        $this->transactionRate = (float)$transactionRate;
    
        return $this;
    }

    /**
     * Get transactionRate
     *
     * @return float 
     */
    public function getTransactionRate()
    {
        return $this->transactionRate;
    }

    /**
     * Set stripeAccessToken
     *
     * @param string $stripeAccessToken
     * @return Account
     */
    public function setStripeAccessToken($stripeAccessToken)
    {
        $this->stripeAccessToken = $stripeAccessToken;
    
        return $this;
    }

    /**
     * Get stripeAccessToken
     *
     * @return string 
     */
    public function getStripeAccessToken()
    {
        return $this->stripeAccessToken;
    }

    /**
     * Set stripeRefreshToken
     *
     * @param string $stripeRefreshToken
     * @return Account
     */
    public function setStripeRefreshToken($stripeRefreshToken)
    {
        $this->stripeRefreshToken = $stripeRefreshToken;
    
        return $this;
    }

    /**
     * Get stripeRefreshToken
     *
     * @return string 
     */
    public function getStripeRefreshToken()
    {
        return $this->stripeRefreshToken;
    }

    /**
     * Set stripePublishableKey
     *
     * @param string $stripePublishableKey
     * @return Account
     */
    public function setStripePublishableKey($stripePublishableKey)
    {
        $this->stripePublishableKey = $stripePublishableKey;
    
        return $this;
    }

    /**
     * Get stripePublishableKey
     *
     * @return string 
     */
    public function getStripePublishableKey()
    {
        return $this->stripePublishableKey;
    }

    /**
     * Set stripeUserId
     *
     * @param string $stripeUserId
     * @return Account
     */
    public function setStripeUserId($stripeUserId)
    {
        $this->stripeUserId = $stripeUserId;
    
        return $this;
    }

    /**
     * Get stripeUserId
     *
     * @return string 
     */
    public function getStripeUserId()
    {
        return $this->stripeUserId;
    }

    /**
     * Add applications
     *
     * @param \MajorApi\AppBundle\Entity\Application $applications
     * @return Account
     */
    public function addApplication(\MajorApi\AppBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;
    
        return $this;
    }

    /**
     * Remove applications
     *
     * @param \MajorApi\AppBundle\Entity\Application $applications
     */
    public function removeApplication(\MajorApi\AppBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Get primary application
     *
     * @return mixed
     */
    public function getPrimaryApplication()
    {
        return $this->getApplications()->first();
    }

    /**
     * Has applications
     *
     * @return boolean
     */
    public function hasApplications()
    {
        return ($this->getApplications()->count() > 0);
    }

}
