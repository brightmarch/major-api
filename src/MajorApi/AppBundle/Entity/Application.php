<?php

namespace MajorApi\AppBundle\Entity;

use MajorApi\AppBundle\Library\Utility\StringUtility;

use Doctrine\Common\Collections\ArrayCollection;

use \DateTime;

class Application extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $accountId;

    /** @var string */
    protected $name;

    /** @var string */
    protected $username;

    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $quickbooksToken;

    /** @var string */
    protected $quickbooksProductName;

    /** @var string */
    protected $quickbooksMajorVersion;

    /** @var string */
    protected $quickbooksMinorVersion;

    /** @var string */
    protected $quickbooksCountry;

    /** @var string */
    protected $quickbooksSupportedQbxmlVersion = '9.0';

    /** @var string */
    protected $quickbooksIsAutomaticLogin = false;

    /** @var string */
    protected $quickbooksQbFileMode;

    /** @var string */
    protected $quickbooksOwnerId;

    /** @var string */
    protected $quickbooksFileId;

    /** @var string */
    protected $quickbooksType;

    /** @var integer */
    protected $quickbooksRealmId;

    /** @var string */
    protected $quickbooksOauthToken;

    /** @var string */
    protected $quickbooksOauthTokenSecret;

    /** @var DateTime */
    protected $quickbooksOauthTokenExpiration;

    /** @var MajorApi\AppBundle\Entity\Account */
    protected $account;

    /** @const string */
    const QUICKBOOKS_TYPE_DESKTOP = 'desktop';

    /** @const string */
    const QUICKBOOKS_TYPE_ONLINE = 'online';

    /** @const integer */
    const QUICKBOOKS_REFRESH_TOKEN_WINDOW_DAYS = 30;

    public function onCreate()
    {
        $su = new StringUtility;

        $this->setCreated(new DateTime)
            ->setUpdated(new DateTime)
            ->setQuickbooksToken($su->randomString(32))
            ->setQuickbooksOwnerId($su->uuid())
            ->setQuickbooksFileId($su->uuid())
            ->enable();

        return true;
    }
    
    public function onUpdate()
    {
        $this->setUpdated(new DateTime);

        return true;
    }

    public function createApiKey($apiKeyLength=16)
    {
        $this->setApiKey((new StringUtility)->randomString($apiKeyLength));

        return $this;
    }

    /**
     * Determines if the application is connected to QuickBooks through the WebConnector.
     *
     * @return boolean
     */
    public function isConnectedToWebConnector()
    {
        return (!empty($this->quickbooksProductName) && !empty($this->quickbooksMajorVersion));
    }

    /**
     * Determines if the application is connected to QuickBooks through the Intuit Partner Platform.
     *
     * @return boolean
     */
    public function isConnectedToIpp()
    {
        return (!empty($this->quickbooksRealmId) && !empty($this->quickbooksOauthToken) && !empty($this->quickbooksOauthTokenSecret));
    }

    /**
     * Determines if the application is for a QuickBooks Desktop installation.
     * This only works for IPP connected QuickBooks installations.
     *
     * @return boolean
     */
    public function isQuickbooksDesktop()
    {
        return ($this->isConnectedToIpp() && $this->getQuickbooksType() === self::QUICKBOOKS_TYPE_DESKTOP);
    }

    /**
     * Determines if the application is for a QuickBooks Online installation.
     * This only works for IPP connected QuickBooks installations.
     *
     * @return boolean
     */
    public function isQuickbooksOnline()
    {
        return ($this->isConnectedToIpp() && $this->getQuickbooksType() === self::QUICKBOOKS_TYPE_ONLINE);
    }

    /**
     * Determines if the application can refresh its QuickBooks IPP OAuth refresh tokens.
     *
     * @return boolean
     */
    public function canRefreshQuickbooksOauthToken()
    {
        $canRefresh = false;
        $date = new DateTime;
    
        if ($this->isConnectedToIpp() && !empty($this->quickbooksOauthTokenExpiration)) {
            $interval = $this->quickbooksOauthTokenExpiration->diff($date);

            // Refreshing a QuickBooks OAuth Token must happen within 30 days
            // of when it expires and can not happen after the expiration date has already passed.
            if ($interval->days < self::QUICKBOOKS_REFRESH_TOKEN_WINDOW_DAYS && $date < $this->quickbooksOauthTokenExpiration) {
                $canRefresh = true;
            }
        }

        return $canRefresh;
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
     * @return Application
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
     * @return Application
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
     * @return Application
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
     * Set accountId
     *
     * @param integer $accountId
     * @return Application
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Application
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
     * Set username
     *
     * @param string $username
     * @return Application
     */
    public function setUsername($username)
    {
        $this->username = strtolower($username);
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set apiKey
     *
     * @param string $apiKey
     * @return Application
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    
        return $this;
    }

    /**
     * Get apiKey
     *
     * @return string 
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set quickbooksToken
     *
     * @param string $quickbooksToken
     * @return Application
     */
    public function setQuickbooksToken($quickbooksToken)
    {
        $this->quickbooksToken = $quickbooksToken;
    
        return $this;
    }

    /**
     * Get quickbooksToken
     *
     * @return string 
     */
    public function getQuickbooksToken()
    {
        return $this->quickbooksToken;
    }

    /**
     * Set quickbooksProductName
     *
     * @param string $quickbooksProductName
     * @return Application
     */
    public function setQuickbooksProductName($quickbooksProductName)
    {
        $this->quickbooksProductName = $quickbooksProductName;
    
        return $this;
    }

    /**
     * Get quickbooksProductName
     *
     * @return string 
     */
    public function getQuickbooksProductName()
    {
        return $this->quickbooksProductName;
    }

    /**
     * Set quickbooksMajorVersion
     *
     * @param string $quickbooksMajorVersion
     * @return Application
     */
    public function setQuickbooksMajorVersion($quickbooksMajorVersion)
    {
        $this->quickbooksMajorVersion = $quickbooksMajorVersion;
    
        return $this;
    }

    /**
     * Get quickbooksMajorVersion
     *
     * @return string 
     */
    public function getQuickbooksMajorVersion()
    {
        return $this->quickbooksMajorVersion;
    }

    /**
     * Set quickbooksMinorVersion
     *
     * @param string $quickbooksMinorVersion
     * @return Application
     */
    public function setQuickbooksMinorVersion($quickbooksMinorVersion)
    {
        $this->quickbooksMinorVersion = $quickbooksMinorVersion;
    
        return $this;
    }

    /**
     * Get quickbooksMinorVersion
     *
     * @return string 
     */
    public function getQuickbooksMinorVersion()
    {
        return $this->quickbooksMinorVersion;
    }

    /**
     * Set quickbooksCountry
     *
     * @param string $quickbooksCountry
     * @return Application
     */
    public function setQuickbooksCountry($quickbooksCountry)
    {
        $this->quickbooksCountry = $quickbooksCountry;
    
        return $this;
    }

    /**
     * Get quickbooksCountry
     *
     * @return string 
     */
    public function getQuickbooksCountry()
    {
        return $this->quickbooksCountry;
    }

    /**
     * Set quickbooksSupportedQbxmlVersion
     *
     * @param string $quickbooksSupportedQbxmlVersion
     * @return Application
     */
    public function setQuickbooksSupportedQbxmlVersion($quickbooksSupportedQbxmlVersion)
    {
        $this->quickbooksSupportedQbxmlVersion = $quickbooksSupportedQbxmlVersion;
    
        return $this;
    }

    /**
     * Get quickbooksSupportedQbxmlVersion
     *
     * @return string 
     */
    public function getQuickbooksSupportedQbxmlVersion()
    {
        return $this->quickbooksSupportedQbxmlVersion;
    }

    /**
     * Set quickbooksIsAutomaticLogin
     *
     * @param boolean $quickbooksIsAutomaticLogin
     * @return Application
     */
    public function setQuickbooksIsAutomaticLogin($quickbooksIsAutomaticLogin)
    {
        $this->quickbooksIsAutomaticLogin = $quickbooksIsAutomaticLogin;
    
        return $this;
    }

    /**
     * Get quickbooksIsAutomaticLogin
     *
     * @return boolean 
     */
    public function getQuickbooksIsAutomaticLogin()
    {
        return $this->quickbooksIsAutomaticLogin;
    }

    /**
     * Set quickbooksQbFileMode
     *
     * @param string $quickbooksQbFileMode
     * @return Application
     */
    public function setQuickbooksQbFileMode($quickbooksQbFileMode)
    {
        $this->quickbooksQbFileMode = $quickbooksQbFileMode;
    
        return $this;
    }

    /**
     * Get quickbooksQbFileMode
     *
     * @return string 
     */
    public function getQuickbooksQbFileMode()
    {
        return $this->quickbooksQbFileMode;
    }

    /**
     * Set quickbooksOwnerId
     *
     * @param string $quickbooksOwnerId
     * @return Application
     */
    public function setQuickbooksOwnerId($quickbooksOwnerId)
    {
        $this->quickbooksOwnerId = $quickbooksOwnerId;
    
        return $this;
    }

    /**
     * Get quickbooksOwnerId
     *
     * @return string 
     */
    public function getQuickbooksOwnerId()
    {
        return $this->quickbooksOwnerId;
    }

    /**
     * Set quickbooksFileId
     *
     * @param string $quickbooksFileId
     * @return Application
     */
    public function setQuickbooksFileId($quickbooksFileId)
    {
        $this->quickbooksFileId = $quickbooksFileId;
    
        return $this;
    }

    /**
     * Get quickbooksFileId
     *
     * @return string 
     */
    public function getQuickbooksFileId()
    {
        return $this->quickbooksFileId;
    }

    /**
     * Set quickbooksType
     *
     * @param string $quickbooksType
     * @return Application
     */
    public function setQuickbooksType($quickbooksType)
    {
        $this->quickbooksType = strtolower($quickbooksType);
    
        return $this;
    }

    /**
     * Get quickbooksType
     *
     * @return string 
     */
    public function getQuickbooksType()
    {
        return $this->quickbooksType;
    }

    /**
     * Set quickbooksRealmId
     *
     * @param integer $quickbooksRealmId
     * @return Application
     */
    public function setQuickbooksRealmId($quickbooksRealmId)
    {
        $this->quickbooksRealmId = (int)$quickbooksRealmId;
    
        return $this;
    }

    /**
     * Get quickbooksRealmId
     *
     * @return integer 
     */
    public function getQuickbooksRealmId()
    {
        return $this->quickbooksRealmId;
    }

    /**
     * Set quickbooksOauthToken
     *
     * @param string $quickbooksOauthToken
     * @return Application
     */
    public function setQuickbooksOauthToken($quickbooksOauthToken)
    {
        $this->quickbooksOauthToken = $quickbooksOauthToken;
    
        return $this;
    }

    /**
     * Get quickbooksOauthToken
     *
     * @return string 
     */
    public function getQuickbooksOauthToken()
    {
        return $this->quickbooksOauthToken;
    }

    /**
     * Set quickbooksOauthTokenSecret
     *
     * @param string $quickbooksOauthTokenSecret
     * @return Application
     */
    public function setQuickbooksOauthTokenSecret($quickbooksOauthTokenSecret)
    {
        $this->quickbooksOauthTokenSecret = $quickbooksOauthTokenSecret;
    
        return $this;
    }

    /**
     * Get quickbooksOauthTokenSecret
     *
     * @return string 
     */
    public function getQuickbooksOauthTokenSecret()
    {
        return $this->quickbooksOauthTokenSecret;
    }

    /**
     * Set quickbooksOauthTokenExpiration
     *
     * @param \DateTime $quickbooksOauthTokenExpiration
     * @return Application
     */
    public function setQuickbooksOauthTokenExpiration($quickbooksOauthTokenExpiration)
    {
        $this->quickbooksOauthTokenExpiration = $quickbooksOauthTokenExpiration;
    
        return $this;
    }

    /**
     * Get quickbooksOauthTokenExpiration
     *
     * @return \DateTime 
     */
    public function getQuickbooksOauthTokenExpiration()
    {
        return $this->quickbooksOauthTokenExpiration;
    }

    /**
     * Set account
     *
     * @param \MajorApi\AppBundle\Entity\Account $account
     * @return Application
     */
    public function setAccount(\MajorApi\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return \MajorApi\AppBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

}
