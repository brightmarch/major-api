<?php

namespace MajorApi\AppBundle\Entity;

use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;

use Doctrine\Common\Collections\ArrayCollection;

use \DateTime;

class QuickbooksInvoice extends \Brightmarch\RestEasy\Entity\Entity
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

    /** @var integer */
    protected $quickbooksCustomerId;

    /** @var string */
    protected $type;

    /** @var string */
    protected $token;

    /** @var DateTime */
    protected $invoiceDate;

    /** @var DateTime */
    protected $dueDate;

    /** @var DateTime */
    protected $shipDate;

    /** @var string */
    protected $refNumber;

    /** @var string */
    protected $poNumber;

    /** @var boolean */
    protected $isPending = false;

    /** @var boolean */
    protected $isFinanceCharge = false;

    /** @var boolean */
    protected $isManuallyClosed = false;

    /** @var boolean */
    protected $isToBePrinted = false;

    /** @var boolean */
    protected $isToBeEmailed = false;

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
    protected $fob;

    /** @var string */
    protected $memo;

    /** @var boolean */
    protected $importable = false;

    /** @var string */
    protected $quickbooksTxnId;

    /** @var string */
    protected $quickbooksTxnNumber;

    /** @var string */
    protected $quickbooksEditSequence;

    /** @var MajorApi\AppBundle\Entity\Application */
    protected $application;

    /** @var MajorApi\AppBundle\Entity\QuickbooksCustomer */
    protected $quickbooksCustomer;

    /** @var Doctrine\Common\Collections\ArrayCollection */
    protected $quickbooksInvoiceLines;

    public function __construct()
    {
        $this->quickbooksInvoiceLines = new ArrayCollection;
    }

    public function onCreate()
    {
        $this->setCreated(new DateTime)
            ->setUpdated(new DateTime)
            ->setInvoiceDate(new DateTime)
            ->enable();

        return true;
    }
    
    public function onUpdate()
    {
        $this->setUpdated(new DateTime);

        return true;
    }

    public function isInvoice()
    {
        return true;
    }

    public function getQueueAction()
    {
        return QuickbooksEnqueuer::ACTION_INVOICE_ADD;
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * Set quickbooksCustomerId
     *
     * @param integer $quickbooksCustomerId
     * @return QuickbooksInvoice
     */
    public function setQuickbooksCustomerId($quickbooksCustomerId)
    {
        $this->quickbooksCustomerId = $quickbooksCustomerId;
    
        return $this;
    }

    /**
     * Get quickbooksCustomerId
     *
     * @return integer 
     */
    public function getQuickbooksCustomerId()
    {
        return $this->quickbooksCustomerId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return QuickbooksInvoice
     */
    public function setType($type)
    {
        $this->type = strtolower($type);
    
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
     * Set token
     *
     * @param string $token
     * @return QuickbooksInvoice
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
     * Set invoiceDate
     *
     * @param \DateTime $invoiceDate
     * @return QuickbooksInvoice
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
    
        return $this;
    }

    /**
     * Get invoiceDate
     *
     * @return \DateTime 
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * Get invoiceDateString
     *
     * @return string
     */
    public function getInvoiceDateString()
    {
        $invoiceDate = (!empty($this->invoiceDate) ? $this->invoiceDate->format('Y-m-d') : '');

        return $invoiceDate;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return QuickbooksInvoice
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    
        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Get dueDateString
     *
     * @return string
     */
    public function getDueDateString()
    {
        $dueDate = (!empty($this->dueDate) ? $this->dueDate->format('Y-m-d') : null);

        return $dueDate;
    }

    /**
     * Set shipDate
     *
     * @param \DateTime $shipDate
     * @return QuickbooksInvoice
     */
    public function setShipDate($shipDate)
    {
        $this->shipDate = $shipDate;
    
        return $this;
    }

    /**
     * Get shipDate
     *
     * @return \DateTime 
     */
    public function getShipDate()
    {
        return $this->shipDate;
    }

    /**
     * Get shipDateString
     *
     * @return string
     */
    public function getShipDateString()
    {
        $shipDate = (!empty($this->shipDate) ? $this->shipDate->format('Y-m-d') : null);

        return $shipDate;
    }

    /**
     * Set refNumber
     *
     * @param string $refNumber
     * @return QuickbooksInvoice
     */
    public function setRefNumber($refNumber)
    {
        $this->refNumber = $refNumber;
    
        return $this;
    }

    /**
     * Get refNumber
     *
     * @return string 
     */
    public function getRefNumber()
    {
        return $this->refNumber;
    }

    /**
     * Set poNumber
     *
     * @param string $poNumber
     * @return QuickbooksInvoice
     */
    public function setPoNumber($poNumber)
    {
        $this->poNumber = $poNumber;
    
        return $this;
    }

    /**
     * Get poNumber
     *
     * @return string 
     */
    public function getPoNumber()
    {
        return $this->poNumber;
    }

    /**
     * Set isPending
     *
     * @param boolean $isPending
     * @return QuickbooksInvoice
     */
    public function setIsPending($isPending)
    {
        $this->isPending = (bool)$isPending;
    
        return $this;
    }

    /**
     * Get isPending
     *
     * @return boolean 
     */
    public function getIsPending()
    {
        return $this->isPending;
    }

    /**
     * Get isPendingString
     *
     * @return string
     */
    public function getIsPendingString()
    {
        return ($this->isPending ? 'true' : 'false');
    }

    /**
     * Set isFinanceCharge
     *
     * @param boolean $isFinanceCharge
     * @return QuickbooksInvoice
     */
    public function setIsFinanceCharge($isFinanceCharge)
    {
        $this->isFinanceCharge = (bool)$isFinanceCharge;
    
        return $this;
    }

    /**
     * Get isFinanceCharge
     *
     * @return boolean 
     */
    public function getIsFinanceCharge()
    {
        return $this->isFinanceCharge;
    }

    /**
     * Get isFinanceChargeString
     *
     * @return boolean 
     */
    public function getIsFinanceChargeString()
    {
        return ($this->isFinanceCharge ? 'true' : 'false');
    }

    /**
     * Set isManuallyClosed
     *
     * @param boolean $isManuallyClosed
     * @return QuickbooksInvoice
     */
    public function setIsManuallyClosed($isManuallyClosed)
    {
        $this->isManuallyClosed = (bool)$isManuallyClosed;
    
        return $this;
    }

    /**
     * Get isManuallyClosed
     *
     * @return boolean 
     */
    public function getIsManuallyClosed()
    {
        return $this->isManuallyClosed;
    }

    /**
     * Get isManuallyClosedString
     *
     * @return string
     */
    public function getIsManuallyClosedString()
    {
        return ($this->isManuallyClosed ? 'true' : 'false');
    }

    /**
     * Set isToBePrinted
     *
     * @param boolean $isToBePrinted
     * @return QuickbooksInvoice
     */
    public function setIsToBePrinted($isToBePrinted)
    {
        $this->isToBePrinted = (bool)$isToBePrinted;
    
        return $this;
    }

    /**
     * Get isToBePrinted
     *
     * @return boolean 
     */
    public function getIsToBePrinted()
    {
        return $this->isToBePrinted;
    }

    /**
     * Get isToBePrintedString
     *
     * @return string
     */
    public function getIsToBePrintedString()
    {
        return ($this->isToBePrinted ? 'true' : 'false');
    }

    /**
     * Set isToBeEmailed
     *
     * @param boolean $isToBeEmailed
     * @return QuickbooksInvoice
     */
    public function setIsToBeEmailed($isToBeEmailed)
    {
        $this->isToBeEmailed = (bool)$isToBeEmailed;
    
        return $this;
    }

    /**
     * Get isToBeEmailed
     *
     * @return boolean 
     */
    public function getIsToBeEmailed()
    {
        return $this->isToBeEmailed;
    }

    /**
     * Get isToBeEmailedString
     *
     * @return string
     */
    public function getIsToBeEmailedString()
    {
        return ($this->isToBeEmailed ? 'true' : 'false');
    }

    /**
     * Set billAddress1
     *
     * @param string $billAddress1
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * Set fob
     *
     * @param string $fob
     * @return QuickbooksInvoice
     */
    public function setFob($fob)
    {
        $this->fob = $fob;
    
        return $this;
    }

    /**
     * Get fob
     *
     * @return string 
     */
    public function getFob()
    {
        return $this->fob;
    }

    /**
     * Set memo
     *
     * @param string $memo
     * @return QuickbooksInvoice
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    
        return $this;
    }

    /**
     * Get memo
     *
     * @return string 
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set importable
     *
     * @param boolean $importable
     * @return QuickbooksInvoice
     */
    public function setImportable($importable)
    {
        $this->importable = (bool)$importable;
    
        return $this;
    }

    /**
     * Get importable
     *
     * @return boolean 
     */
    public function getImportable()
    {
        return $this->importable;
    }

    /**
     * Set quickbooksTxnId
     *
     * @param string $quickbooksTxnId
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * @return QuickbooksInvoice
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
     * Add quickbooksInvoiceLines
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksInvoiceLine $quickbooksInvoiceLines
     * @return QuickbooksInvoice
     */
    public function addQuickbooksInvoiceLine(\MajorApi\AppBundle\Entity\QuickbooksInvoiceLine $quickbooksInvoiceLines)
    {
        $this->quickbooksInvoiceLines[] = $quickbooksInvoiceLines;
    
        return $this;
    }

    /**
     * Remove quickbooksInvoiceLines
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksInvoiceLine $quickbooksInvoiceLines
     */
    public function removeQuickbooksInvoiceLine(\MajorApi\AppBundle\Entity\QuickbooksInvoiceLine $quickbooksInvoiceLines)
    {
        $this->quickbooksInvoiceLines->removeElement($quickbooksInvoiceLines);
    }

    /**
     * Get quickbooksInvoiceLines
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuickbooksInvoiceLines()
    {
        return $this->quickbooksInvoiceLines;
    }

    /**
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksInvoice
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

    /**
     * Set quickbooksCustomer
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksCustomer $quickbooksCustomer
     * @return QuickbooksInvoice
     */
    public function setQuickbooksCustomer(\MajorApi\AppBundle\Entity\QuickbooksCustomer $quickbooksCustomer = null)
    {
        $this->quickbooksCustomer = $quickbooksCustomer;
    
        return $this;
    }

    /**
     * Get quickbooksCustomer
     *
     * @return \MajorApi\AppBundle\Entity\QuickbooksCustomer 
     */
    public function getQuickbooksCustomer()
    {
        return $this->quickbooksCustomer;
    }

}
