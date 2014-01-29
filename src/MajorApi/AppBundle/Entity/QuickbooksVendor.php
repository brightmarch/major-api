<?php

namespace MajorApi\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use \DateTime;

class QuickbooksVendor extends \Brightmarch\RestEasy\Entity\Entity
{

    /** @var integer */
    protected $id;

    /** @var DateTime */
    protected $created;

    /** @var DateTime */
    protected $updated;

    /** @var integer */
    protected $status = 0;

    /** @var integer */
    protected $applicationId;

    /** @var string */
    protected $token;

    /** @var string */
    protected $name;

    /** @var string */
    protected $fullname;

    /** @var boolean */
    protected $isActive = true;

    /** @var string */
    protected $companyName;

    /** @var string */
    protected $salutation;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $middleName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $jobTitle;

    /** @var string */
    protected $vendorAddressAddress1;

    /** @var string */
    protected $vendorAddressAddress2;

    /** @var string */
    protected $vendorAddressAddress3;

    /** @var string */
    protected $vendorAddressAddress4;

    /** @var string */
    protected $vendorAddressAddress5;

    /** @var string */
    protected $vendorAddressCity;

    /** @var string */
    protected $vendorAddressState;

    /** @var string */
    protected $vendorAddressPostalCode;

    /** @var string */
    protected $vendorAddressCountry;

    /** @var string */
    protected $vendorAddressNote;

    /** @var string */
    protected $shipAddress1;

    /** @var string */
    protected $shipAddress2;

    /** @var string */
    protected $shipAddress3;

    /** @var string */
    protected $shipAddress4;

    /** @var string */
    protected $shipAddress5;

    /** @var string */
    protected $shipCity;

    /** @var string */
    protected $shipState;

    /** @var string */
    protected $shipPostalCode;

    /** @var string */
    protected $shipCountry;

    /** @var string */
    protected $shipNote;

    /** @var string */
    protected $phone;

    /** @var string */
    protected $altPhone;

    /** @var string */
    protected $fax;

    /** @var string */
    protected $email;

    /** @var string */
    protected $emailCc;

    /** @var string */
    protected $contact;

    /** @var string */
    protected $altContact;

    /** @var string */
    protected $nameOnCheck;

    /** @var string */
    protected $accountNumber;

    /** @var string */
    protected $notes;

    /** @var decimal */
    protected $creditLimit = 0.0;

    /** @var string */
    protected $vendorTaxIdentity;

    /** @var boolean */
    protected $isVendorEligibleFor1099 = false;

    /** @var decimal */
    protected $balance = 0.0;

    /** @var string */
    protected $quickbooksListId;

    /** @var string */
    protected $quickbooksEditSequence;

    /** @var string */
    protected $quickbooksNameToken;

    /** @var MajorApi\AppBundle\Entity\Application */
    protected $application;

    /** @var Doctrine\Common\Collections\ArrayCollection */
    protected $quickbooksVendorContacts;

    /** @var Doctrine\Common\Collections\ArrayCollection */
    protected $quickbooksVendorNotes;

    public function __construct()
    {
        $this->quickbooksVendorContacts = new ArrayCollection;
        $this->quickbooksVendorNotes = new ArrayCollection;
    }

    public function onCreate()
    {
        $this->setCreated(new DateTime)
            ->setUpdated(new DateTime)
            ->enable();

        return true;
    }

    public function onUpdate()
    {
        $this->setUpdated(new DateTime);

        return true;
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
     * @return QuickbooksVendor
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
     * @return QuickbooksVendor
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
     * @return QuickbooksVendor
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
     * Set applicationId
     *
     * @param integer $applicationId
     * @return QuickbooksVendor
     */
    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;
    
        return $this;
    }

    /**
     * Get applicationId
     *
     * @return integer 
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return QuickbooksVendor
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return QuickbooksVendor
     */
    public function setName($name)
    {
        $this->name = strtoupper($name);
        $this->setQuickbooksNameToken(md5(strtoupper($name)));
    
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
     * Set fullname
     *
     * @param string $fullname
     * @return QuickbooksVendor
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    
        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return QuickbooksVendor
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return QuickbooksVendor
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    
        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set salutation
     *
     * @param string $salutation
     * @return QuickbooksVendor
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
    
        return $this;
    }

    /**
     * Get salutation
     *
     * @return string 
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return QuickbooksVendor
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
     * Set middleName
     *
     * @param string $middleName
     * @return QuickbooksVendor
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    
        return $this;
    }

    /**
     * Get middleName
     *
     * @return string 
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return QuickbooksVendor
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
     * Set jobTitle
     *
     * @param string $jobTitle
     * @return QuickbooksVendor
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    
        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string 
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set vendorAddressAddress1
     *
     * @param string $vendorAddressAddress1
     * @return QuickbooksVendor
     */
    public function setVendorAddressAddress1($vendorAddressAddress1)
    {
        $this->vendorAddressAddress1 = $vendorAddressAddress1;
    
        return $this;
    }

    /**
     * Get vendorAddressAddress1
     *
     * @return string 
     */
    public function getVendorAddressAddress1()
    {
        return $this->vendorAddressAddress1;
    }

    /**
     * Set vendorAddressAddress2
     *
     * @param string $vendorAddressAddress2
     * @return QuickbooksVendor
     */
    public function setVendorAddressAddress2($vendorAddressAddress2)
    {
        $this->vendorAddressAddress2 = $vendorAddressAddress2;
    
        return $this;
    }

    /**
     * Get vendorAddressAddress2
     *
     * @return string 
     */
    public function getVendorAddressAddress2()
    {
        return $this->vendorAddressAddress2;
    }

    /**
     * Set vendorAddressAddress3
     *
     * @param string $vendorAddressAddress3
     * @return QuickbooksVendor
     */
    public function setVendorAddressAddress3($vendorAddressAddress3)
    {
        $this->vendorAddressAddress3 = $vendorAddressAddress3;
    
        return $this;
    }

    /**
     * Get vendorAddressAddress3
     *
     * @return string 
     */
    public function getVendorAddressAddress3()
    {
        return $this->vendorAddressAddress3;
    }

    /**
     * Set vendorAddressAddress4
     *
     * @param string $vendorAddressAddress4
     * @return QuickbooksVendor
     */
    public function setVendorAddressAddress4($vendorAddressAddress4)
    {
        $this->vendorAddressAddress4 = $vendorAddressAddress4;
    
        return $this;
    }

    /**
     * Get vendorAddressAddress4
     *
     * @return string 
     */
    public function getVendorAddressAddress4()
    {
        return $this->vendorAddressAddress4;
    }

    /**
     * Set vendorAddressAddress5
     *
     * @param string $vendorAddressAddress5
     * @return QuickbooksVendor
     */
    public function setVendorAddressAddress5($vendorAddressAddress5)
    {
        $this->vendorAddressAddress5 = $vendorAddressAddress5;
    
        return $this;
    }

    /**
     * Get vendorAddressAddress5
     *
     * @return string 
     */
    public function getVendorAddressAddress5()
    {
        return $this->vendorAddressAddress5;
    }

    /**
     * Set vendorAddressCity
     *
     * @param string $vendorAddressCity
     * @return QuickbooksVendor
     */
    public function setVendorAddressCity($vendorAddressCity)
    {
        $this->vendorAddressCity = $vendorAddressCity;
    
        return $this;
    }

    /**
     * Get vendorAddressCity
     *
     * @return string 
     */
    public function getVendorAddressCity()
    {
        return $this->vendorAddressCity;
    }

    /**
     * Set vendorAddressState
     *
     * @param string $vendorAddressState
     * @return QuickbooksVendor
     */
    public function setVendorAddressState($vendorAddressState)
    {
        $this->vendorAddressState = $vendorAddressState;
    
        return $this;
    }

    /**
     * Get vendorAddressState
     *
     * @return string 
     */
    public function getVendorAddressState()
    {
        return $this->vendorAddressState;
    }

    /**
     * Set vendorAddressPostalCode
     *
     * @param string $vendorAddressPostalCode
     * @return QuickbooksVendor
     */
    public function setVendorAddressPostalCode($vendorAddressPostalCode)
    {
        $this->vendorAddressPostalCode = $vendorAddressPostalCode;
    
        return $this;
    }

    /**
     * Get vendorAddressPostalCode
     *
     * @return string 
     */
    public function getVendorAddressPostalCode()
    {
        return $this->vendorAddressPostalCode;
    }

    /**
     * Set vendorAddressCountry
     *
     * @param string $vendorAddressCountry
     * @return QuickbooksVendor
     */
    public function setVendorAddressCountry($vendorAddressCountry)
    {
        $this->vendorAddressCountry = $vendorAddressCountry;
    
        return $this;
    }

    /**
     * Get vendorAddressCountry
     *
     * @return string 
     */
    public function getVendorAddressCountry()
    {
        return $this->vendorAddressCountry;
    }

    /**
     * Set vendorAddressNote
     *
     * @param string $vendorAddressNote
     * @return QuickbooksVendor
     */
    public function setVendorAddressNote($vendorAddressNote)
    {
        $this->vendorAddressNote = $vendorAddressNote;
    
        return $this;
    }

    /**
     * Get vendorAddressNote
     *
     * @return string 
     */
    public function getVendorAddressNote()
    {
        return $this->vendorAddressNote;
    }

    /**
     * Set shipAddress1
     *
     * @param string $shipAddress1
     * @return QuickbooksVendor
     */
    public function setShipAddress1($shipAddress1)
    {
        $this->shipAddress1 = $shipAddress1;
    
        return $this;
    }

    /**
     * Get shipAddress1
     *
     * @return string 
     */
    public function getShipAddress1()
    {
        return $this->shipAddress1;
    }

    /**
     * Set shipAddress2
     *
     * @param string $shipAddress2
     * @return QuickbooksVendor
     */
    public function setShipAddress2($shipAddress2)
    {
        $this->shipAddress2 = $shipAddress2;
    
        return $this;
    }

    /**
     * Get shipAddress2
     *
     * @return string 
     */
    public function getShipAddress2()
    {
        return $this->shipAddress2;
    }

    /**
     * Set shipAddress3
     *
     * @param string $shipAddress3
     * @return QuickbooksVendor
     */
    public function setShipAddress3($shipAddress3)
    {
        $this->shipAddress3 = $shipAddress3;
    
        return $this;
    }

    /**
     * Get shipAddress3
     *
     * @return string 
     */
    public function getShipAddress3()
    {
        return $this->shipAddress3;
    }

    /**
     * Set shipAddress4
     *
     * @param string $shipAddress4
     * @return QuickbooksVendor
     */
    public function setShipAddress4($shipAddress4)
    {
        $this->shipAddress4 = $shipAddress4;
    
        return $this;
    }

    /**
     * Get shipAddress4
     *
     * @return string 
     */
    public function getShipAddress4()
    {
        return $this->shipAddress4;
    }

    /**
     * Set shipAddress5
     *
     * @param string $shipAddress5
     * @return QuickbooksVendor
     */
    public function setShipAddress5($shipAddress5)
    {
        $this->shipAddress5 = $shipAddress5;
    
        return $this;
    }

    /**
     * Get shipAddress5
     *
     * @return string 
     */
    public function getShipAddress5()
    {
        return $this->shipAddress5;
    }

    /**
     * Set shipCity
     *
     * @param string $shipCity
     * @return QuickbooksVendor
     */
    public function setShipCity($shipCity)
    {
        $this->shipCity = $shipCity;
    
        return $this;
    }

    /**
     * Get shipCity
     *
     * @return string 
     */
    public function getShipCity()
    {
        return $this->shipCity;
    }

    /**
     * Set shipState
     *
     * @param string $shipState
     * @return QuickbooksVendor
     */
    public function setShipState($shipState)
    {
        $this->shipState = $shipState;
    
        return $this;
    }

    /**
     * Get shipState
     *
     * @return string 
     */
    public function getShipState()
    {
        return $this->shipState;
    }

    /**
     * Set shipPostalCode
     *
     * @param string $shipPostalCode
     * @return QuickbooksVendor
     */
    public function setShipPostalCode($shipPostalCode)
    {
        $this->shipPostalCode = $shipPostalCode;
    
        return $this;
    }

    /**
     * Get shipPostalCode
     *
     * @return string 
     */
    public function getShipPostalCode()
    {
        return $this->shipPostalCode;
    }

    /**
     * Set shipCountry
     *
     * @param string $shipCountry
     * @return QuickbooksVendor
     */
    public function setShipCountry($shipCountry)
    {
        $this->shipCountry = $shipCountry;
    
        return $this;
    }

    /**
     * Get shipCountry
     *
     * @return string 
     */
    public function getShipCountry()
    {
        return $this->shipCountry;
    }

    /**
     * Set shipNote
     *
     * @param string $shipNote
     * @return QuickbooksVendor
     */
    public function setShipNote($shipNote)
    {
        $this->shipNote = $shipNote;
    
        return $this;
    }

    /**
     * Get shipNote
     *
     * @return string 
     */
    public function getShipNote()
    {
        return $this->shipNote;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return QuickbooksVendor
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set altPhone
     *
     * @param string $altPhone
     * @return QuickbooksVendor
     */
    public function setAltPhone($altPhone)
    {
        $this->altPhone = $altPhone;
    
        return $this;
    }

    /**
     * Get altPhone
     *
     * @return string 
     */
    public function getAltPhone()
    {
        return $this->altPhone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return QuickbooksVendor
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return QuickbooksVendor
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
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
     * Set emailCc
     *
     * @param string $emailCc
     * @return QuickbooksVendor
     */
    public function setEmailCc($emailCc)
    {
        $this->emailCc = $emailCc;
    
        return $this;
    }

    /**
     * Get emailCc
     *
     * @return string 
     */
    public function getEmailCc()
    {
        return $this->emailCc;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return QuickbooksVendor
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set altContact
     *
     * @param string $altContact
     * @return QuickbooksVendor
     */
    public function setAltContact($altContact)
    {
        $this->altContact = $altContact;
    
        return $this;
    }

    /**
     * Get altContact
     *
     * @return string 
     */
    public function getAltContact()
    {
        return $this->altContact;
    }

    /**
     * Set nameOnCheck
     *
     * @param string $nameOnCheck
     * @return QuickbooksVendor
     */
    public function setNameOnCheck($nameOnCheck)
    {
        $this->nameOnCheck = $nameOnCheck;
    
        return $this;
    }

    /**
     * Get nameOnCheck
     *
     * @return string 
     */
    public function getNameOnCheck()
    {
        return $this->nameOnCheck;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     * @return QuickbooksVendor
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    
        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string 
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return QuickbooksVendor
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set creditLimit
     *
     * @param float $creditLimit
     * @return QuickbooksVendor
     */
    public function setCreditLimit($creditLimit)
    {
        $this->creditLimit = $creditLimit;
    
        return $this;
    }

    /**
     * Get creditLimit
     *
     * @return float 
     */
    public function getCreditLimit()
    {
        return $this->creditLimit;
    }

    /**
     * Set vendorTaxIdentity
     *
     * @param string $vendorTaxIdentity
     * @return QuickbooksVendor
     */
    public function setVendorTaxIdentity($vendorTaxIdentity)
    {
        $this->vendorTaxIdentity = $vendorTaxIdentity;
    
        return $this;
    }

    /**
     * Get vendorTaxIdentity
     *
     * @return string 
     */
    public function getVendorTaxIdentity()
    {
        return $this->vendorTaxIdentity;
    }

    /**
     * Set isVendorEligibleFor1099
     *
     * @param boolean $isVendorEligibleFor1099
     * @return QuickbooksVendor
     */
    public function setIsVendorEligibleFor1099($isVendorEligibleFor1099)
    {
        $this->isVendorEligibleFor1099 = $isVendorEligibleFor1099;
    
        return $this;
    }

    /**
     * Get isVendorEligibleFor1099
     *
     * @return boolean 
     */
    public function getIsVendorEligibleFor1099()
    {
        return $this->isVendorEligibleFor1099;
    }

    /**
     * Set balance
     *
     * @param float $balance
     * @return QuickbooksVendor
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    
        return $this;
    }

    /**
     * Get balance
     *
     * @return float 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksVendor
     */
    public function setQuickbooksListId($quickbooksListId)
    {
        $this->quickbooksListId = $quickbooksListId;
    
        return $this;
    }

    /**
     * Get quickbooksListId
     *
     * @return string 
     */
    public function getQuickbooksListId()
    {
        return $this->quickbooksListId;
    }

    /**
     * Set quickbooksEditSequence
     *
     * @param string $quickbooksEditSequence
     * @return QuickbooksVendor
     */
    public function setQuickbooksEditSequence($quickbooksEditSequence)
    {
        $this->quickbooksEditSequence = $quickbooksEditSequence;
    
        return $this;
    }

    /**
     * Get quickbooksEditSequence
     *
     * @return string 
     */
    public function getQuickbooksEditSequence()
    {
        return $this->quickbooksEditSequence;
    }

    /**
     * Set quickbooksNameToken
     *
     * @param string $quickbooksNameToken
     * @return QuickbooksVendor
     */
    public function setQuickbooksNameToken($quickbooksNameToken)
    {
        $this->quickbooksNameToken = $quickbooksNameToken;
    
        return $this;
    }

    /**
     * Get quickbooksNameToken
     *
     * @return string 
     */
    public function getQuickbooksNameToken()
    {
        return $this->quickbooksNameToken;
    }

    /**
     * Add quickbooksVendorContacts
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksVendorContact $quickbooksVendorContacts
     * @return QuickbooksVendor
     */
    public function addQuickbooksVendorContact(\MajorApi\AppBundle\Entity\QuickbooksVendorContact $quickbooksVendorContacts)
    {
        $this->quickbooksVendorContacts[] = $quickbooksVendorContacts;
    
        return $this;
    }

    /**
     * Remove quickbooksVendorContacts
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksVendorContact $quickbooksVendorContacts
     */
    public function removeQuickbooksVendorContact(\MajorApi\AppBundle\Entity\QuickbooksVendorContact $quickbooksVendorContacts)
    {
        $this->quickbooksVendorContacts->removeElement($quickbooksVendorContacts);
    }

    /**
     * Get quickbooksVendorContacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuickbooksVendorContacts()
    {
        return $this->quickbooksVendorContacts;
    }

    /**
     * Add quickbooksVendorNotes
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksVendorNote $quickbooksVendorNotes
     * @return QuickbooksVendor
     */
    public function addQuickbooksVendorNote(\MajorApi\AppBundle\Entity\QuickbooksVendorNote $quickbooksVendorNotes)
    {
        $this->quickbooksVendorNotes[] = $quickbooksVendorNotes;
    
        return $this;
    }

    /**
     * Remove quickbooksVendorNotes
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksVendorNote $quickbooksVendorNotes
     */
    public function removeQuickbooksVendorNote(\MajorApi\AppBundle\Entity\QuickbooksVendorNote $quickbooksVendorNotes)
    {
        $this->quickbooksVendorNotes->removeElement($quickbooksVendorNotes);
    }

    /**
     * Get quickbooksVendorNotes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuickbooksVendorNotes()
    {
        return $this->quickbooksVendorNotes;
    }

    /**
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksVendor
     */
    public function setApplication(\MajorApi\AppBundle\Entity\Application $application = null)
    {
        $this->application = $application;
    
        return $this;
    }

    /**
     * Get application
     *
     * @return \MajorApi\AppBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

}
