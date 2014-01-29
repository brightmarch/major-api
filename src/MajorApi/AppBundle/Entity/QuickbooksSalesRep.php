<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksSalesRep extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $initial;

    /** @var boolean */
    protected $isActive = true;

    /** @var string */
    protected $quickbooksListId;

    /** @var string */
    protected $quickbooksEditSequence;

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
     * @return QuickbooksSalesRep
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
     * @return QuickbooksSalesRep
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
     * @return QuickbooksSalesRep
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
     * @return QuickbooksSalesRep
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
     * Set initial
     *
     * @param string $initial
     * @return QuickbooksSalesRep
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;
    
        return $this;
    }

    /**
     * Get initial
     *
     * @return string 
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return QuickbooksSalesRep
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
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksSalesRep
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
     * @return QuickbooksSalesRep
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
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksSalesRep
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
