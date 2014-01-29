<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksVendorContact extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $quickbooksVendorId;

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
    protected $contactRefName1;

    /** @var string */
    protected $contactRefValue1;

    /** @var string */
    protected $contactRefName2;

    /** @var string */
    protected $contactRefValue2;

    /** @var string */
    protected $contactRefName3;

    /** @var string */
    protected $contactRefValue3;

    /** @var string */
    protected $contactRefName4;

    /** @var string */
    protected $contactRefValue4;

    /** @var string */
    protected $contactRefName5;

    /** @var string */
    protected $contactRefValue5;

    /** @var string */
    protected $quickbooksListId;

    /** @var string */
    protected $quickbooksEditSequence;

    /** @var MajorApi\AppBundle\Entity\QuickbooksVendor */
    protected $quickbooksVendor;

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
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * Set quickbooksVendorId
     *
     * @param integer $quickbooksVendorId
     * @return QuickbooksVendorContact
     */
    public function setQuickbooksVendorId($quickbooksVendorId)
    {
        $this->quickbooksVendorId = $quickbooksVendorId;
    
        return $this;
    }

    /**
     * Get quickbooksVendorId
     *
     * @return integer 
     */
    public function getQuickbooksVendorId()
    {
        return $this->quickbooksVendorId;
    }

    /**
     * Set salutation
     *
     * @param string $salutation
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * Set contactRefName1
     *
     * @param string $contactRefName1
     * @return QuickbooksVendorContact
     */
    public function setContactRefName1($contactRefName1)
    {
        $this->contactRefName1 = $contactRefName1;
    
        return $this;
    }

    /**
     * Get contactRefName1
     *
     * @return string 
     */
    public function getContactRefName1()
    {
        return $this->contactRefName1;
    }

    /**
     * Set contactRefValue1
     *
     * @param string $contactRefValue1
     * @return QuickbooksVendorContact
     */
    public function setContactRefValue1($contactRefValue1)
    {
        $this->contactRefValue1 = $contactRefValue1;
    
        return $this;
    }

    /**
     * Get contactRefValue1
     *
     * @return string 
     */
    public function getContactRefValue1()
    {
        return $this->contactRefValue1;
    }

    /**
     * Set contactRefName2
     *
     * @param string $contactRefName2
     * @return QuickbooksVendorContact
     */
    public function setContactRefName2($contactRefName2)
    {
        $this->contactRefName2 = $contactRefName2;
    
        return $this;
    }

    /**
     * Get contactRefName2
     *
     * @return string 
     */
    public function getContactRefName2()
    {
        return $this->contactRefName2;
    }

    /**
     * Set contactRefValue2
     *
     * @param string $contactRefValue2
     * @return QuickbooksVendorContact
     */
    public function setContactRefValue2($contactRefValue2)
    {
        $this->contactRefValue2 = $contactRefValue2;
    
        return $this;
    }

    /**
     * Get contactRefValue2
     *
     * @return string 
     */
    public function getContactRefValue2()
    {
        return $this->contactRefValue2;
    }

    /**
     * Set contactRefName3
     *
     * @param string $contactRefName3
     * @return QuickbooksVendorContact
     */
    public function setContactRefName3($contactRefName3)
    {
        $this->contactRefName3 = $contactRefName3;
    
        return $this;
    }

    /**
     * Get contactRefName3
     *
     * @return string 
     */
    public function getContactRefName3()
    {
        return $this->contactRefName3;
    }

    /**
     * Set contactRefValue3
     *
     * @param string $contactRefValue3
     * @return QuickbooksVendorContact
     */
    public function setContactRefValue3($contactRefValue3)
    {
        $this->contactRefValue3 = $contactRefValue3;
    
        return $this;
    }

    /**
     * Get contactRefValue3
     *
     * @return string 
     */
    public function getContactRefValue3()
    {
        return $this->contactRefValue3;
    }

    /**
     * Set contactRefName4
     *
     * @param string $contactRefName4
     * @return QuickbooksVendorContact
     */
    public function setContactRefName4($contactRefName4)
    {
        $this->contactRefName4 = $contactRefName4;
    
        return $this;
    }

    /**
     * Get contactRefName4
     *
     * @return string 
     */
    public function getContactRefName4()
    {
        return $this->contactRefName4;
    }

    /**
     * Set contactRefValue4
     *
     * @param string $contactRefValue4
     * @return QuickbooksVendorContact
     */
    public function setContactRefValue4($contactRefValue4)
    {
        $this->contactRefValue4 = $contactRefValue4;
    
        return $this;
    }

    /**
     * Get contactRefValue4
     *
     * @return string 
     */
    public function getContactRefValue4()
    {
        return $this->contactRefValue4;
    }

    /**
     * Set contactRefName5
     *
     * @param string $contactRefName5
     * @return QuickbooksVendorContact
     */
    public function setContactRefName5($contactRefName5)
    {
        $this->contactRefName5 = $contactRefName5;
    
        return $this;
    }

    /**
     * Get contactRefName5
     *
     * @return string 
     */
    public function getContactRefName5()
    {
        return $this->contactRefName5;
    }

    /**
     * Set contactRefValue5
     *
     * @param string $contactRefValue5
     * @return QuickbooksVendorContact
     */
    public function setContactRefValue5($contactRefValue5)
    {
        $this->contactRefValue5 = $contactRefValue5;
    
        return $this;
    }

    /**
     * Get contactRefValue5
     *
     * @return string 
     */
    public function getContactRefValue5()
    {
        return $this->contactRefValue5;
    }

    /**
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksVendorContact
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
     * @return QuickbooksVendorContact
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
     * Set quickbooksVendor
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksVendor $quickbooksVendor
     * @return QuickbooksVendorContact
     */
    public function setQuickbooksVendor(\MajorApi\AppBundle\Entity\QuickbooksVendor $quickbooksVendor = null)
    {
        $this->quickbooksVendor = $quickbooksVendor;
    
        return $this;
    }

    /**
     * Get quickbooksVendor
     *
     * @return \MajorApi\AppBundle\Entity\QuickbooksVendor 
     */
    public function getQuickbooksVendor()
    {
        return $this->quickbooksVendor;
    }

}
