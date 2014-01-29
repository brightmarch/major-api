<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksInvoiceLine extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $quickbooksInvoiceId;

    /** @var integer */
    protected $quickbooksItemId;

    /** @var string */
    protected $itemName;

    /** @var string */
    protected $itemDescription;

    /** @var float */
    protected $quantityOrdered = 0.0;

    /** @var string */
    protected $unitOfMeasure;

    /** @var float */
    protected $rate = 0.0;

    /** @var float */
    protected $ratePercent = 0.0;

    /** @var float */
    protected $amount = 0.0;

    /** @var string */
    protected $serialNumber;

    /** @var string */
    protected $lotNumber;

    /** @var string */
    protected $other1;

    /** @var string */
    protected $other2;

    /** @var float */
    protected $unitPrice = 0.0;

    /** @var float */
    protected $cost = 0.0;

    /** @var MajorApi\AppBundle\Entity\QuickbooksInvoice */
    protected $quickbooksInvoice;

    /** @var MajorApi\AppBundle\Entity\QuickbooksItem */
    protected $quickbooksItem;

    public function onCreate()
    {
        $this->setCreated(new DateTime)
            ->setUpdated(new DateTime)
            ->calculate()
            ->enable();

        return true;
    }
    
    public function onUpdate()
    {
        $this->setUpdated(new DateTime)
            ->calculate();

        return true;
    }

    public function calculate()
    {
        $this->setAmount($this->getUnitPrice() * $this->getQuantityOrdered());

        return $this;
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
     * @return QuickbooksInvoiceLine
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
     * @return QuickbooksInvoiceLine
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
     * @return QuickbooksInvoiceLine
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
     * Set quickbooksInvoiceId
     *
     * @param integer $quickbooksInvoiceId
     * @return QuickbooksInvoiceLine
     */
    public function setQuickbooksInvoiceId($quickbooksInvoiceId)
    {
        $this->quickbooksInvoiceId = $quickbooksInvoiceId;
    
        return $this;
    }

    /**
     * Get quickbooksInvoiceId
     *
     * @return integer 
     */
    public function getQuickbooksInvoiceId()
    {
        return $this->quickbooksInvoiceId;
    }

    /**
     * Set quickbooksItemId
     *
     * @param integer $quickbooksItemId
     * @return QuickbooksInvoiceLine
     */
    public function setQuickbooksItemId($quickbooksItemId)
    {
        $this->quickbooksItemId = $quickbooksItemId;
    
        return $this;
    }

    /**
     * Get quickbooksItemId
     *
     * @return integer 
     */
    public function getQuickbooksItemId()
    {
        return $this->quickbooksItemId;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     * @return QuickbooksInvoiceLine
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    
        return $this;
    }

    /**
     * Get itemName
     *
     * @return string 
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set itemDescription
     *
     * @param string $itemDescription
     * @return QuickbooksInvoiceLine
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    
        return $this;
    }

    /**
     * Get itemDescription
     *
     * @return string 
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * Set quantityOrdered
     *
     * @param float $quantityOrdered
     * @return QuickbooksInvoiceLine
     */
    public function setQuantityOrdered($quantityOrdered)
    {
        $this->quantityOrdered = (float)$quantityOrdered;
        $this->calculate();
    
        return $this;
    }

    /**
     * Get quantityOrdered
     *
     * @return float 
     */
    public function getQuantityOrdered()
    {
        return $this->quantityOrdered;
    }

    /**
     * Set unitOfMeasure
     *
     * @param string $unitOfMeasure
     * @return QuickbooksInvoiceLine
     */
    public function setUnitOfMeasure($unitOfMeasure)
    {
        $this->unitOfMeasure = $unitOfMeasure;
    
        return $this;
    }

    /**
     * Get unitOfMeasure
     *
     * @return string 
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return QuickbooksInvoiceLine
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    
        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set ratePercent
     *
     * @param float $ratePercent
     * @return QuickbooksInvoiceLine
     */
    public function setRatePercent($ratePercent)
    {
        $this->ratePercent = $ratePercent;
    
        return $this;
    }

    /**
     * Get ratePercent
     *
     * @return float 
     */
    public function getRatePercent()
    {
        return $this->ratePercent;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return QuickbooksInvoiceLine
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set serialNumber
     *
     * @param string $serialNumber
     * @return QuickbooksInvoiceLine
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
    
        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return string 
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set lotNumber
     *
     * @param string $lotNumber
     * @return QuickbooksInvoiceLine
     */
    public function setLotNumber($lotNumber)
    {
        $this->lotNumber = $lotNumber;
    
        return $this;
    }

    /**
     * Get lotNumber
     *
     * @return string 
     */
    public function getLotNumber()
    {
        return $this->lotNumber;
    }

    /**
     * Set other1
     *
     * @param string $other1
     * @return QuickbooksInvoiceLine
     */
    public function setOther1($other1)
    {
        $this->other1 = $other1;
    
        return $this;
    }

    /**
     * Get other1
     *
     * @return string 
     */
    public function getOther1()
    {
        return $this->other1;
    }

    /**
     * Set other2
     *
     * @param string $other2
     * @return QuickbooksInvoiceLine
     */
    public function setOther2($other2)
    {
        $this->other2 = $other2;
    
        return $this;
    }

    /**
     * Get other2
     *
     * @return string 
     */
    public function getOther2()
    {
        return $this->other2;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     * @return QuickbooksInvoiceLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        $this->calculate();
    
        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return QuickbooksInvoiceLine
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set isManuallyClosed
     *
     * @param boolean $isManuallyClosed
     * @return QuickbooksInvoiceLine
     */
    public function setIsManuallyClosed($isManuallyClosed)
    {
        $this->isManuallyClosed = (bool)$isManuallyClosed;
    
        return $this;
    }

    /**
     * Set quickbooksInvoice
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksInvoice $quickbooksInvoice
     * @return QuickbooksInvoiceLine
     */
    public function setQuickbooksInvoice(\MajorApi\AppBundle\Entity\QuickbooksInvoice $quickbooksInvoice = null)
    {
        $this->quickbooksInvoice = $quickbooksInvoice;
    
        return $this;
    }

    /**
     * Get quickbooksInvoice
     *
     * @return \MajorApi\AppBundle\Entity\QuickbooksInvoice 
     */
    public function getQuickbooksInvoice()
    {
        return $this->quickbooksInvoice;
    }

    /**
     * Set quickbooksItem
     *
     * @param \MajorApi\AppBundle\Entity\QuickbooksItem $quickbooksItem
     * @return QuickbooksInvoiceLine
     */
    public function setQuickbooksItem(\MajorApi\AppBundle\Entity\QuickbooksItem $quickbooksItem = null)
    {
        $this->quickbooksItem = $quickbooksItem;
    
        return $this;
    }

    /**
     * Get quickbooksItem
     *
     * @return \MajorApi\AppBundle\Entity\QuickbooksItem 
     */
    public function getQuickbooksItem()
    {
        return $this->quickbooksItem;
    }

}
