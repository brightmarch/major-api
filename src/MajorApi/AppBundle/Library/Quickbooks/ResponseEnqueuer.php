<?php

namespace MajorApi\AppBundle\Library\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksQbxml;
use MajorApi\AppBundle\Entity\Application;

use Doctrine\ORM\EntityManager;

use \Resque;

class ResponseEnqueuer
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /** @var integer */
    private $applicationId = 0;

    /** @const string */
    const WORKER_CLASS = 'MajorApi\Worker\ProcessQbxmlWorker';

    /** @const string */
    const QUEUE = 'qbxml';

    public function __construct(EntityManager $entityManager, Application $application, $resqueDsn)
    {
        $this->entityManager = $entityManager;
        $this->application = $application;
        $this->applicationId = (int)$application->getId();

        Resque::setBackend($resqueDsn);
    }

    public function enqueue($qbxml)
    {
        // First save the QBXML in the database. This allows us to check
        // it if it ever errors out and allows us to easily re-enqueue it.
        $quickbooksQbxml = $this->persistQuickbooksQbxml($qbxml);
        $qbxmlHash = $quickbooksQbxml->getQbxmlHash();

        $parameters = [
            'applicationId' => $this->applicationId,
            'qbxmlHash' => $qbxmlHash
        ];

        // And enqueue a reference to the application and QBXML for
        // the majorapi-worker servers to handle.
        $token = Resque::enqueue(self::QUEUE, self::WORKER_CLASS, $parameters, true);

        return [$token, $qbxmlHash];
    }

    private function persistQuickbooksQbxml($qbxml)
    {
        $quickbooksQbxml = new QuickbooksQbxml;
        $quickbooksQbxml->setApplication($this->application)
            ->setQbxml($qbxml);

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksQbxml);
        $entityManager->flush($quickbooksQbxml);

        return $quickbooksQbxml;
    }

}
