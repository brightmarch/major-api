<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksQbxml extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $qbxmlHash;

    /** @var string */
    protected $qbxml;

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
     * @return QuickbooksQbxml
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
     * @return QuickbooksQbxml
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
     * @return QuickbooksQbxml
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
     * @return QuickbooksQbxml
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
     * Set qbxmlHash
     *
     * @param string $qbxmlHash
     * @return QuickbooksQbxml
     */
    public function setQbxmlHash($qbxmlHash)
    {
        $this->qbxmlHash = $qbxmlHash;
    
        return $this;
    }

    /**
     * Get qbxmlHash
     *
     * @return string 
     */
    public function getQbxmlHash()
    {
        return $this->qbxmlHash;
    }

    /**
     * Set qbxml
     *
     * @param string $qbxml
     * @return QuickbooksQbxml
     */
    public function setQbxml($qbxml)
    {
        $this->qbxml = $qbxml;
        $this->setQbxmlHash(md5($qbxml));
    
        return $this;
    }

    /**
     * Get qbxml
     *
     * @return string 
     */
    public function getQbxml()
    {
        return $this->qbxml;
    }

    /**
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksQbxml
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
