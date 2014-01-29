<?php

namespace MajorApi\AppBundle\Library\Quickbooks;

use MajorApi\AppBundle\Entity\Application;

use Doctrine\ORM\EntityManager;

use \ReflectionClass;

class CommandCompiler
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /* @var integer */
    private $applicationId = 0;

    /** @var Twig */
    private $twig;

    /** @var array */
    private $commands = [
        'AccountQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\AccountQueryCommand',
        'CustomerAddCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\CustomerAddCommand',
        'CustomerQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\CustomerQueryCommand',
        'HostQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\HostQueryCommand',
        'InvoiceAddCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\InvoiceAddCommand',
        'InvoiceQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\InvoiceQueryCommand',
        'ItemNonInventoryAddCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\ItemNonInventoryAddCommand',
        'ItemQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\ItemQueryCommand',
        'SalesRepQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\SalesRepQueryCommand',
        'VendorQueryCommand' => 'MajorApi\AppBundle\Library\Quickbooks\Command\VendorQueryCommand'
    ];

    public function __construct(EntityManager $entityManager, Application $application, $twig)
    {
        $this->entityManager = $entityManager;
        $this->application = $application;
        $this->applicationId = (int)$application->getId();
        $this->twig = $twig;
    }

    public function compile()
    {
        $qbxml = [];

        $search = [
            'applicationId' => $this->applicationId,
            'processed' => null
        ];

        // Find all unprocessed queues for this Major Application.
        $quickbooksQueues = $this->entityManager
            ->getRepository('MajorApiAppBundle:QuickbooksQueue')
            ->findBy($search);

        foreach ($quickbooksQueues as $quickbooksQueue) {
            $quickbooksQueueCommand = $quickbooksQueue->getCommand();

            // If they have a valid command class, instantiate it
            // and compile all of the QBXML to send to QuickBooks.
            if (array_key_exists($quickbooksQueueCommand, $this->commands)) {
                $quickbooksQueueReflection = new ReflectionClass($this->commands[$quickbooksQueueCommand]);
                $command = $quickbooksQueueReflection->newInstance(
                    $this->entityManager,
                    $this->application,
                    $this->twig
                );

                $qbxml[] = $command->getXml();
            }
        }

        return $this->renderQbxml(implode('', $qbxml));
    }

    private function renderQbxml($qbxml)
    {
        // QuickBooks requires some supported QBXML version, which we find
        // from the Major Application. By default, applications have 9.0
        // as the supported version.
        $template = 'MajorApiAppBundle:ApiQbxml:qbxml.xml.twig';
        $supportedQbxmlVersion = $this->application->getQuickbooksSupportedQbxmlVersion();

        $parameters = [
            'supportedQbxmlVersion' => $supportedQbxmlVersion,
            'qbxml' => $qbxml
        ];

        return $this->twig->render($template, $parameters);
    }

}
