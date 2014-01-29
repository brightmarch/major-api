<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksAccount extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $name;

    /** @var string */
    protected $fullname;

    /** @var boolean */
    protected $isActive = true;

    /** @var integer */
    protected $sublevel = 0;

    /** @var string */
    protected $type;

    /** @var string */
    protected $specialType;

    /** @var string */
    protected $accountNumber;

    /** @var string */
    protected $bankNumber;

    /** @var string */
    protected $description;

    /** @var decimal */
    protected $balance = 0.0;

    /** @var decimal */
    protected $totalBalance = 0.0;

    /** @var string */
    protected $cashFlowClassification;

    /** @var string */
    protected $quickbooksListId;

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
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * Set name
     *
     * @param string $name
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * Set sublevel
     *
     * @param integer $sublevel
     * @return QuickbooksAccount
     */
    public function setSublevel($sublevel)
    {
        $this->sublevel = $sublevel;
    
        return $this;
    }

    /**
     * Get sublevel
     *
     * @return integer 
     */
    public function getSublevel()
    {
        return $this->sublevel;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return QuickbooksAccount
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set specialType
     *
     * @param string $specialType
     * @return QuickbooksAccount
     */
    public function setSpecialType($specialType)
    {
        $this->specialType = $specialType;
    
        return $this;
    }

    /**
     * Get specialType
     *
     * @return string 
     */
    public function getSpecialType()
    {
        return $this->specialType;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     * @return QuickbooksAccount
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
     * Set bankNumber
     *
     * @param string $bankNumber
     * @return QuickbooksAccount
     */
    public function setBankNumber($bankNumber)
    {
        $this->bankNumber = $bankNumber;
    
        return $this;
    }

    /**
     * Get bankNumber
     *
     * @return string 
     */
    public function getBankNumber()
    {
        return $this->bankNumber;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return QuickbooksAccount
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set balance
     *
     * @param float $balance
     * @return QuickbooksAccount
     */
    public function setBalance($balance)
    {
        $this->balance = (float)$balance;
    
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
     * Set totalBalance
     *
     * @param float $totalBalance
     * @return QuickbooksAccount
     */
    public function setTotalBalance($totalBalance)
    {
        $this->totalBalance = (float)$totalBalance;
    
        return $this;
    }

    /**
     * Get totalBalance
     *
     * @return float 
     */
    public function getTotalBalance()
    {
        return $this->totalBalance;
    }

    /**
     * Set cashFlowClassification
     *
     * @param string $cashFlowClassification
     * @return QuickbooksAccount
     */
    public function setCashFlowClassification($cashFlowClassification)
    {
        $this->cashFlowClassification = $cashFlowClassification;
    
        return $this;
    }

    /**
     * Get cashFlowClassification
     *
     * @return string 
     */
    public function getCashFlowClassification()
    {
        return $this->cashFlowClassification;
    }

    /**
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
     * @return QuickbooksAccount
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
