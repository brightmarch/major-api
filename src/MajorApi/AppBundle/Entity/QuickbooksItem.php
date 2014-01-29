<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksItem extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $type;

    /** @var string */
    protected $name;

    /** @var string */
    protected $fullname;

    /** @var boolean */
    protected $isActive = true;

    /** @var integer */
    protected $sublevel = 0;

    /** @var string */
    protected $salesDescription;

    /** @var float */
    protected $salesPrice = 0.0;

    /** @var float */
    protected $salesExpense = 0.0;

    /** @var DateTime */
    protected $salesDate;

    /** @var string */
    protected $purchaseDescription;

    /** @var float */
    protected $purchasePrice = 0.0;

    /** @var float */
    protected $purchaseCost = 0.0;

    /** @var DateTime */
    protected $purchaseDate;

    /** @var string */
    protected $description;

    /** @var string */
    protected $itemDescription;

    /** @var float */
    protected $price = 0.0;

    /** @var float */
    protected $pricePercent = 0.0;

    /** @var float */
    protected $discountRate = 0.0;

    /** @var float */
    protected $discountRatePercent = 0.0;

    /** @var string */
    protected $barCode;

    /** @var string */
    protected $manufacturerPartNumber;

    /** @var integer */
    protected $quantityReorder = 0;

    /** @var integer */
    protected $quantityOnHand = 0;

    /** @var integer */
    protected $quantityOnOrder = 0;

    /** @var integer */
    protected $quantityOnSalesOrder = 0;

    /** @var float */
    protected $averageCost = 0.0;

    /** @var string */
    protected $vendorOrPayeeName;

    /** @var string */
    protected $acquiredAs;

    /** @var string */
    protected $assetDescription;

    /** @var string */
    protected $location;

    /** @var string */
    protected $poNumber;

    /** @var string */
    protected $serialNumber;

    /** @var string */
    protected $warrantyExpirationDate;

    /** @var string */
    protected $notes;

    /** @var string */
    protected $assetNumber;

    /** @var float */
    protected $costBasis = 0.0;

    /** @var float */
    protected $yearEndAccumulatedDepreciation = 0.0;

    /** @var float */
    protected $yearEndBookValue = 0.0;

    /** @var string */
    protected $externalGuid;

    /** @var string */
    protected $quickbooksListId;

    /** @var string */
    protected $quickbooksEditSequence;

    /** @var MajorApi\AppBundle\Entity\Application */
    protected $application;

    /** @const string */
    const TYPE_DISCOUNT = 'discount';

    /** @const string */
    const TYPE_FIXED_ASSET = 'fixed-asset';

    /** @const string */
    const TYPE_GROUP = 'group';

    /** @const string */
    const TYPE_INVENTORY = 'inventory';

    /** @const string */
    const TYPE_NON_INVENTORY = 'non-inventory';

    /** @const string */
    const TYPE_SERVICE = 'service';

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
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
     * Set type
     *
     * @param string $type
     * @return QuickbooksItem
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
     * Set name
     *
     * @param string $name
     * @return QuickbooksItem
     */
    public function setName($name)
    {
        $this->name = $name;
    
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
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
     * Set salesDescription
     *
     * @param string $salesDescription
     * @return QuickbooksItem
     */
    public function setSalesDescription($salesDescription)
    {
        $this->salesDescription = $salesDescription;
    
        return $this;
    }

    /**
     * Get salesDescription
     *
     * @return string 
     */
    public function getSalesDescription()
    {
        return $this->salesDescription;
    }

    /**
     * Set salesPrice
     *
     * @param float $salesPrice
     * @return QuickbooksItem
     */
    public function setSalesPrice($salesPrice)
    {
        $this->salesPrice = $salesPrice;
    
        return $this;
    }

    /**
     * Get salesPrice
     *
     * @return float 
     */
    public function getSalesPrice()
    {
        return $this->salesPrice;
    }

    /**
     * Set salesExpense
     *
     * @param float $salesExpense
     * @return QuickbooksItem
     */
    public function setSalesExpense($salesExpense)
    {
        $this->salesExpense = $salesExpense;
    
        return $this;
    }

    /**
     * Get salesExpense
     *
     * @return float 
     */
    public function getSalesExpense()
    {
        return $this->salesExpense;
    }

    /**
     * Set salesDate
     *
     * @param \DateTime $salesDate
     * @return QuickbooksItem
     */
    public function setSalesDate($salesDate)
    {
        $this->salesDate = $salesDate;
    
        return $this;
    }

    /**
     * Get salesDate
     *
     * @return \DateTime 
     */
    public function getSalesDate()
    {
        return $this->salesDate;
    }

    /**
     * Get salesDateString
     *
     * @return string
     */
    public function getSalesDateString()
    {
        return (!empty($this->salesDate) ? $this->salesDate->format('Y-m-d') : '');
    }

    /**
     * Set purchaseDescription
     *
     * @param string $purchaseDescription
     * @return QuickbooksItem
     */
    public function setPurchaseDescription($purchaseDescription)
    {
        $this->purchaseDescription = $purchaseDescription;
    
        return $this;
    }

    /**
     * Get purchaseDescription
     *
     * @return string 
     */
    public function getPurchaseDescription()
    {
        return $this->purchaseDescription;
    }

    /**
     * Set purchasePrice
     *
     * @param float $purchasePrice
     * @return QuickbooksItem
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;
    
        return $this;
    }

    /**
     * Get purchasePrice
     *
     * @return float 
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * Set purchaseCost
     *
     * @param float $purchaseCost
     * @return QuickbooksItem
     */
    public function setPurchaseCost($purchaseCost)
    {
        $this->purchaseCost = $purchaseCost;
    
        return $this;
    }

    /**
     * Get purchaseCost
     *
     * @return float 
     */
    public function getPurchaseCost()
    {
        return $this->purchaseCost;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     * @return QuickbooksItem
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;
    
        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime 
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Get purchaseDateString
     *
     * @return string
     */
    public function getPurchaseDateString()
    {
        return (!empty($this->purchaseDate) ? $this->purchaseDate->format('Y-m-d') : '');
    }

    /**
     * Set description
     *
     * @param string $description
     * @return QuickbooksItem
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
     * Set itemDescription
     *
     * @param string $itemDescription
     * @return QuickbooksItem
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
     * Set price
     *
     * @param float $price
     * @return QuickbooksItem
     */
    public function setPrice($price)
    {
        $this->price = (float)$price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set pricePercent
     *
     * @param float $pricePercent
     * @return QuickbooksItem
     */
    public function setPricePercent($pricePercent)
    {
        $this->pricePercent = $pricePercent;
    
        return $this;
    }

    /**
     * Get pricePercent
     *
     * @return float 
     */
    public function getPricePercent()
    {
        return $this->pricePercent;
    }

    /**
     * Set discountRate
     *
     * @param float $discountRate
     * @return QuickbooksItem
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;
    
        return $this;
    }

    /**
     * Get discountRate
     *
     * @return float 
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * Set discountRatePercent
     *
     * @param float $discountRatePercent
     * @return QuickbooksItem
     */
    public function setDiscountRatePercent($discountRatePercent)
    {
        $this->discountRatePercent = $discountRatePercent;
    
        return $this;
    }

    /**
     * Get discountRatePercent
     *
     * @return float 
     */
    public function getDiscountRatePercent()
    {
        return $this->discountRatePercent;
    }

    /**
     * Set barCode
     *
     * @param string $barCode
     * @return QuickbooksItem
     */
    public function setBarCode($barCode)
    {
        $this->barCode = $barCode;
    
        return $this;
    }

    /**
     * Get barCode
     *
     * @return string 
     */
    public function getBarCode()
    {
        return $this->barCode;
    }

    /**
     * Set manufacturerPartNumber
     *
     * @param string $manufacturerPartNumber
     * @return QuickbooksItem
     */
    public function setManufacturerPartNumber($manufacturerPartNumber)
    {
        $this->manufacturerPartNumber = $manufacturerPartNumber;
    
        return $this;
    }

    /**
     * Get manufacturerPartNumber
     *
     * @return string 
     */
    public function getManufacturerPartNumber()
    {
        return $this->manufacturerPartNumber;
    }

    /**
     * Set quantityReorder
     *
     * @param integer $quantityReorder
     * @return QuickbooksItem
     */
    public function setQuantityReorder($quantityReorder)
    {
        $this->quantityReorder = $quantityReorder;
    
        return $this;
    }

    /**
     * Get quantityReorder
     *
     * @return integer 
     */
    public function getQuantityReorder()
    {
        return $this->quantityReorder;
    }

    /**
     * Set quantityOnHand
     *
     * @param integer $quantityOnHand
     * @return QuickbooksItem
     */
    public function setQuantityOnHand($quantityOnHand)
    {
        $this->quantityOnHand = $quantityOnHand;
    
        return $this;
    }

    /**
     * Get quantityOnHand
     *
     * @return integer 
     */
    public function getQuantityOnHand()
    {
        return $this->quantityOnHand;
    }

    /**
     * Set quantityOnOrder
     *
     * @param integer $quantityOnOrder
     * @return QuickbooksItem
     */
    public function setQuantityOnOrder($quantityOnOrder)
    {
        $this->quantityOnOrder = $quantityOnOrder;
    
        return $this;
    }

    /**
     * Get quantityOnOrder
     *
     * @return integer 
     */
    public function getQuantityOnOrder()
    {
        return $this->quantityOnOrder;
    }

    /**
     * Set quantityOnSalesOrder
     *
     * @param integer $quantityOnSalesOrder
     * @return QuickbooksItem
     */
    public function setQuantityOnSalesOrder($quantityOnSalesOrder)
    {
        $this->quantityOnSalesOrder = $quantityOnSalesOrder;
    
        return $this;
    }

    /**
     * Get quantityOnSalesOrder
     *
     * @return integer 
     */
    public function getQuantityOnSalesOrder()
    {
        return $this->quantityOnSalesOrder;
    }

    /**
     * Set averageCost
     *
     * @param float $averageCost
     * @return QuickbooksItem
     */
    public function setAverageCost($averageCost)
    {
        $this->averageCost = $averageCost;
    
        return $this;
    }

    /**
     * Get averageCost
     *
     * @return float 
     */
    public function getAverageCost()
    {
        return $this->averageCost;
    }

    /**
     * Set vendorOrPayeeName
     *
     * @param string $vendorOrPayeeName
     * @return QuickbooksItem
     */
    public function setVendorOrPayeeName($vendorOrPayeeName)
    {
        $this->vendorOrPayeeName = $vendorOrPayeeName;
    
        return $this;
    }

    /**
     * Get vendorOrPayeeName
     *
     * @return string 
     */
    public function getVendorOrPayeeName()
    {
        return $this->vendorOrPayeeName;
    }

    /**
     * Set acquiredAs
     *
     * @param string $acquiredAs
     * @return QuickbooksItem
     */
    public function setAcquiredAs($acquiredAs)
    {
        $this->acquiredAs = $acquiredAs;
    
        return $this;
    }

    /**
     * Get acquiredAs
     *
     * @return string 
     */
    public function getAcquiredAs()
    {
        return $this->acquiredAs;
    }

    /**
     * Set assetDescription
     *
     * @param string $assetDescription
     * @return QuickbooksItem
     */
    public function setAssetDescription($assetDescription)
    {
        $this->assetDescription = $assetDescription;
    
        return $this;
    }

    /**
     * Get assetDescription
     *
     * @return string 
     */
    public function getAssetDescription()
    {
        return $this->assetDescription;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return QuickbooksItem
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set poNumber
     *
     * @param string $poNumber
     * @return QuickbooksItem
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
     * Set serialNumber
     *
     * @param string $serialNumber
     * @return QuickbooksItem
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
     * Set warrantyExpirationDate
     *
     * @param \DateTime $warrantyExpirationDate
     * @return QuickbooksItem
     */
    public function setWarrantyExpirationDate($warrantyExpirationDate)
    {
        $this->warrantyExpirationDate = $warrantyExpirationDate;
    
        return $this;
    }

    /**
     * Get warrantyExpirationDate
     *
     * @return \DateTime 
     */
    public function getWarrantyExpirationDate()
    {
        return $this->warrantyExpirationDate;
    }

    /**
     * Get warrantyExpirationDateString
     *
     * @return string
     */
    public function getWarrantyExpirationDateString()
    {
        return (!empty($this->warrantyExpirationDate) ? $this->warrantyExpirationDate->format('Y-m-d') : '');
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return QuickbooksItem
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
     * Set assetNumber
     *
     * @param string $assetNumber
     * @return QuickbooksItem
     */
    public function setAssetNumber($assetNumber)
    {
        $this->assetNumber = $assetNumber;
    
        return $this;
    }

    /**
     * Get assetNumber
     *
     * @return string 
     */
    public function getAssetNumber()
    {
        return $this->assetNumber;
    }

    /**
     * Set costBasis
     *
     * @param float $costBasis
     * @return QuickbooksItem
     */
    public function setCostBasis($costBasis)
    {
        $this->costBasis = $costBasis;
    
        return $this;
    }

    /**
     * Get costBasis
     *
     * @return float 
     */
    public function getCostBasis()
    {
        return $this->costBasis;
    }

    /**
     * Set yearEndAccumulatedDepreciation
     *
     * @param float $yearEndAccumulatedDepreciation
     * @return QuickbooksItem
     */
    public function setYearEndAccumulatedDepreciation($yearEndAccumulatedDepreciation)
    {
        $this->yearEndAccumulatedDepreciation = $yearEndAccumulatedDepreciation;
    
        return $this;
    }

    /**
     * Get yearEndAccumulatedDepreciation
     *
     * @return float 
     */
    public function getYearEndAccumulatedDepreciation()
    {
        return $this->yearEndAccumulatedDepreciation;
    }

    /**
     * Set yearEndBookValue
     *
     * @param float $yearEndBookValue
     * @return QuickbooksItem
     */
    public function setYearEndBookValue($yearEndBookValue)
    {
        $this->yearEndBookValue = $yearEndBookValue;
    
        return $this;
    }

    /**
     * Get yearEndBookValue
     *
     * @return float 
     */
    public function getYearEndBookValue()
    {
        return $this->yearEndBookValue;
    }

    /**
     * Set externalGuid
     *
     * @param string $externalGuid
     * @return QuickbooksItem
     */
    public function setExternalGuid($externalGuid)
    {
        $this->externalGuid = $externalGuid;
    
        return $this;
    }

    /**
     * Get externalGuid
     *
     * @return string 
     */
    public function getExternalGuid()
    {
        return $this->externalGuid;
    }

    /**
     * Set quickbooksListId
     *
     * @param string $quickbooksListId
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
     * @return QuickbooksItem
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
