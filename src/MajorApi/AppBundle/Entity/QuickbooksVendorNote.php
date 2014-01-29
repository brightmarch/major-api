<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksVendorNote extends \Brightmarch\RestEasy\Entity\Entity
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

    /** @var DateTime */
    protected $noteDate;

    /** @var text */
    protected $note;

    /** @var string */
    protected $quickbooksListId;

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
     * @return QuickbooksVendorNote
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
     * @return QuickbooksVendorNote
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
     * @return QuickbooksVendorNote
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
     * @return QuickbooksVendorNote
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
     * Set noteDate
     *
     * @param \DateTime $noteDate
     * @return QuickbooksVendorNote
     */
    public function setNoteDate($noteDate)
    {
        $this->noteDate = $noteDate;
    
        return $this;
    }

    /**
     * Get noteDate
     *
     * @return \DateTime 
     */
    public function getNoteDate()
    {
        return $this->noteDate;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return QuickbooksVendorNote
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksVendorNote
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
     * Set quickbooksVendor
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksVendor $quickbooksVendor
     * @return QuickbooksVendorNote
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
