<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksCustomer extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $billAddress1;

    /** @var string */
    protected $billAddress2;

    /** @var string */
    protected $billAddress3;

    /** @var string */
    protected $billAddress4;

    /** @var string */
    protected $billAddress5;

    /** @var string */
    protected $billCity;

    /** @var string */
    protected $billState;

    /** @var string */
    protected $billPostalCode;

    /** @var string */
    protected $billCountry;

    /** @var string */
    protected $billNote;

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
    protected $notes;

    /** @var string */
    protected $quickbooksListId;

    /** @var string */
    protected $quickbooksTxnId;

    /** @var string */
    protected $quickbooksTxnNumber;

    /** @var string */
    protected $quickbooksEditSequence;

    /** @var string */
    protected $quickbooksNameToken;

    /** @var MajorApi\AppBundle\Entity\Application */
    protected $application;

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

    public function hasQuickbooksListId()
    {
        return !empty($this->quickbooksListId);
    }

    public function hasQuickbooksEditSequence()
    {
        return !empty($this->quickbooksEditSequence);
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return QuickbooksCustomer
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
     * Get isActiveString
     *
     * @return string
     */
    public function getIsActiveString()
    {
        return ($this->isActive ? 'true' : 'false');
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * Set billAddress1
     *
     * @param string $billAddress1
     * @return QuickbooksCustomer
     */
    public function setBillAddress1($billAddress1)
    {
        $this->billAddress1 = $billAddress1;
    
        return $this;
    }

    /**
     * Get billAddress1
     *
     * @return string 
     */
    public function getBillAddress1()
    {
        return $this->billAddress1;
    }

    /**
     * Set billAddress2
     *
     * @param string $billAddress2
     * @return QuickbooksCustomer
     */
    public function setBillAddress2($billAddress2)
    {
        $this->billAddress2 = $billAddress2;
    
        return $this;
    }

    /**
     * Get billAddress2
     *
     * @return string 
     */
    public function getBillAddress2()
    {
        return $this->billAddress2;
    }

    /**
     * Set billAddress3
     *
     * @param string $billAddress3
     * @return QuickbooksCustomer
     */
    public function setBillAddress3($billAddress3)
    {
        $this->billAddress3 = $billAddress3;
    
        return $this;
    }

    /**
     * Get billAddress3
     *
     * @return string 
     */
    public function getBillAddress3()
    {
        return $this->billAddress3;
    }

    /**
     * Set billAddress4
     *
     * @param string $billAddress4
     * @return QuickbooksCustomer
     */
    public function setBillAddress4($billAddress4)
    {
        $this->billAddress4 = $billAddress4;
    
        return $this;
    }

    /**
     * Get billAddress4
     *
     * @return string 
     */
    public function getBillAddress4()
    {
        return $this->billAddress4;
    }

    /**
     * Set billAddress5
     *
     * @param string $billAddress5
     * @return QuickbooksCustomer
     */
    public function setBillAddress5($billAddress5)
    {
        $this->billAddress5 = $billAddress5;
    
        return $this;
    }

    /**
     * Get billAddress5
     *
     * @return string 
     */
    public function getBillAddress5()
    {
        return $this->billAddress5;
    }

    /**
     * Set billCity
     *
     * @param string $billCity
     * @return QuickbooksCustomer
     */
    public function setBillCity($billCity)
    {
        $this->billCity = $billCity;
    
        return $this;
    }

    /**
     * Get billCity
     *
     * @return string 
     */
    public function getBillCity()
    {
        return $this->billCity;
    }

    /**
     * Set billState
     *
     * @param string $billState
     * @return QuickbooksCustomer
     */
    public function setBillState($billState)
    {
        $this->billState = $billState;
    
        return $this;
    }

    /**
     * Get billState
     *
     * @return string 
     */
    public function getBillState()
    {
        return $this->billState;
    }

    /**
     * Set billPostalCode
     *
     * @param string $billPostalCode
     * @return QuickbooksCustomer
     */
    public function setBillPostalCode($billPostalCode)
    {
        $this->billPostalCode = $billPostalCode;
    
        return $this;
    }

    /**
     * Get billPostalCode
     *
     * @return string 
     */
    public function getBillPostalCode()
    {
        return $this->billPostalCode;
    }

    /**
     * Set billCountry
     *
     * @param string $billCountry
     * @return QuickbooksCustomer
     */
    public function setBillCountry($billCountry)
    {
        $this->billCountry = $billCountry;
    
        return $this;
    }

    /**
     * Get billCountry
     *
     * @return string 
     */
    public function getBillCountry()
    {
        return $this->billCountry;
    }

    /**
     * Set billNote
     *
     * @param string $billNote
     * @return QuickbooksCustomer
     */
    public function setBillNote($billNote)
    {
        $this->billNote = $billNote;
    
        return $this;
    }

    /**
     * Get billNote
     *
     * @return string 
     */
    public function getBillNote()
    {
        return $this->billNote;
    }

    /**
     * Set shipAddress1
     *
     * @param string $shipAddress1
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * Set notes
     *
     * @param string $notes
     * @return QuickbooksCustomer
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
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksCustomer
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
     * Set quickbooksTxnId
     *
     * @param string $quickbooksTxnId
     * @return QuickbooksCustomer
     */
    public function setQuickbooksTxnId($quickbooksTxnId)
    {
        $this->quickbooksTxnId = $quickbooksTxnId;
    
        return $this;
    }

    /**
     * Get quickbooksTxnId
     *
     * @return string 
     */
    public function getQuickbooksTxnId()
    {
        return $this->quickbooksTxnId;
    }

    /**
     * Set quickbooksTxnNumber
     *
     * @param string $quickbooksTxnNumber
     * @return QuickbooksCustomer
     */
    public function setQuickbooksTxnNumber($quickbooksTxnNumber)
    {
        $this->quickbooksTxnNumber = $quickbooksTxnNumber;
    
        return $this;
    }

    /**
     * Get quickbooksTxnNumber
     *
     * @return string 
     */
    public function getQuickbooksTxnNumber()
    {
        return $this->quickbooksTxnNumber;
    }

    /**
     * Set quickbooksEditSequence
     *
     * @param string $quickbooksEditSequence
     * @return QuickbooksCustomer
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
     * @return QuickbooksCustomer
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
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksCustomer
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
