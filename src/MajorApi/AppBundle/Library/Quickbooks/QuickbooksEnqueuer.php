<?php

namespace MajorApi\AppBundle\Library\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksQueue;
use MajorApi\AppBundle\Entity\Application;

use Doctrine\ORM\EntityManager;

use \Resque;

class QuickbooksEnqueuer
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /* @var integer */
    private $applicationId = 0;

    /** @var array */
    private static $actions = [
        self::ACTION_NULL => ['NullCommand', 'NullPersister'],
        self::ACTION_ACCOUNT_QUERY => ['AccountQueryCommand', 'AccountQueryPersister'],
        self::ACTION_CUSTOMER_ADD => ['CustomerAddCommand', 'CustomerAddPersister'],
        self::ACTION_CUSTOMER_QUERY => ['CustomerQueryCommand', 'CustomerQueryPersister'],
        self::ACTION_HOST_QUERY => ['HostQueryCommand', 'HostQueryPersister'],
        self::ACTION_INVOICE_ADD => ['InvoiceAddCommand', 'InvoiceAddPersister'],
        self::ACTION_INVOICE_QUERY => ['InvoiceQueryCommand', 'InvoiceQueryPersister'],
        self::ACTION_ITEM_NON_INVENTORY_ADD => ['ItemNonInventoryAddCommand', 'ItemNonInventoryAddPersister'],
        self::ACTION_ITEM_QUERY => ['ItemQueryCommand', 'ItemQueryPersister'],
        self::ACTION_SALES_REP_QUERY => ['SalesRepQueryCommand', 'SalesRepQueryPersister'],
        self::ACTION_VENDOR_QUERY => ['VendorQueryCommand', 'VendorQueryPersister']
    ];

    /** @const string */
    const ACTION_NULL = 'Null';

    /** @const string */
    const ACTION_ACCOUNT_QUERY = 'AccountQuery';

    /** @const string */
    const ACTION_CUSTOMER_ADD = 'CustomerAdd';

    /** @const string */
    const ACTION_CUSTOMER_QUERY = 'CustomerQuery';

    /** @const string */
    const ACTION_HOST_QUERY = 'HostQuery';

    /** @const string */
    const ACTION_INVOICE_ADD = 'InvoiceAdd';

    /** @const string */
    const ACTION_INVOICE_QUERY = 'InvoiceQuery';

    /** @const string */
    const ACTION_ITEM_NON_INVENTORY_ADD = 'ItemNonInventoryAdd';

    /** @const string */
    const ACTION_ITEM_QUERY = 'ItemQuery';

    /** @const string */
    const ACTION_SALES_REP_QUERY = 'SalesRepQuery';

    /** @const string */
    const ACTION_VENDOR_QUERY = 'VendorQuery';

    /** @const string */
    const WORKER_CLASS = 'MajorApi\Worker\ProcessIppRequestWorker';

    /** @const string */
    const QUEUE = 'ipp-requests';

    public function __construct(EntityManager $entityManager, Application $application, $resqueDsn)
    {
        $this->entityManager = $entityManager;
        $this->application = $application;
        $this->applicationId = (int)$application->getId();

        Resque::setBackend($resqueDsn);
    }

    public function enqueue($action, $objectId=0)
    {
        // If the action exists, make sure that it is not already enqueued.
        if ($this->actionExists($action)) {
            // If the action is already enqueued, just ignore the request depending on
            // the type of application making the request. See hasUnprocessedQueue() for more
            // details on how this works.
            if (!$this->hasUnprocessedQueue($action)) {
                $isIpp = $this->application->isConnectedToIpp();

                $quickbooksQueue = new QuickbooksQueue;
                $quickbooksQueue->setApplication($this->application)
                    ->setCommand(self::$actions[$action][0])
                    ->setPersister(self::$actions[$action][1])
                    ->setIsIpp($isIpp);

                $entityManager = $this->entityManager;
                $entityManager->persist($quickbooksQueue);
                $entityManager->flush($quickbooksQueue);

                // If this application is connected to IPP, enqueue the record in Resque.
                // That way, the Resque worker will handle making the actual request to IPP, getting
                // the XML, parsing, and persisting it.
                if ($isIpp) {
                    $parameters = [
                        'applicationId' => $this->applicationId,
                        'quickbooksQueueId' => $quickbooksQueue->getId(),
                        'objectId' => (int)abs($objectId)
                    ];

                    $queueToken = Resque::enqueue(self::QUEUE, self::WORKER_CLASS, $parameters, true);

                    $quickbooksQueue->setQueueToken($queueToken);
                    $entityManager->persist($quickbooksQueue);
                    $entityManager->flush($quickbooksQueue);
                }

                return $quickbooksQueue;
            }
        }

        return false;
    }

    public function hasUnprocessedQueue($action)
    {
        $count = 0;

        // If the application is NOT connected to IPP and the action exists,
        // check for duplicate entries. The reason we do this is that IPP does
        // not allow batch object creation, so each request that gets enqueued
        // must be sent to the workers to send to IPP. However, the WebConnector
        // does support batch object creation, so only one request needs to be
        // sent at a time.
        if (!$this->application->isConnectedToIpp() && $this->actionExists($action)) {
            $dql = "SELECT COUNT(qq) FROM MajorApiAppBundle:QuickbooksQueue qq
                WHERE qq.applicationId = ?1
                    AND qq.processed IS NULL
                    AND qq.command = ?2
                    AND qq.persister = ?3";

            $query = $this->entityManager->createQuery($dql);
            $count = (int)$query->setParameter(1, $this->applicationId)
                ->setParameter(2, self::$actions[$action][0])
                ->setParameter(3, self::$actions[$action][1])
                ->getSingleScalarResult();
        }

        return (0 !== $count);
    }

    public static function getActions()
    {
        return self::$actions;
    }

    public static function getActionClasses($action)
    {
        $actionClasses = [null, null];

        if (array_key_exists($action, self::$actions)) {
            $actionClasses = self::$actions[$action];
        }

        return $actionClasses;
    }

    private function actionExists($action)
    {
        return array_key_exists($action, self::$actions);
    }

}
