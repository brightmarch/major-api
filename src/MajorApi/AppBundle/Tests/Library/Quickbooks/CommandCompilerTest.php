<?php

namespace MajorApi\AppBundle\Tests\Library\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksQueue;
use MajorApi\AppBundle\Library\Quickbooks\CommandCompiler;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\MajorApi\ApplicationConfigurator;
use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

use \DateTime,
    \DOMDocument,
    \DOMXpath;

/**
 * @group FunctionalTests
 * @group LibraryTests
 */
class CommandCompilerTest extends TestCase
{

    use FunctionalMixin;

    public function testCommandCompilerCompilesQuickbooksQueueElements()
    {
        // By creating a new ApplicationConfigurator object, we will automatically
        // enqueue several commands that are necessary to connect to QuickBooks.
        $resqueDsn = static::$kernel->getContainer()->getParameter('resque_dsn');

        $applicationConfigurator = new ApplicationConfigurator(
            $this->entityManager,
            static::$fixtures['application'],
            $resqueDsn
        );

        $applicationConfigurator->configure();

        $commandCompiler = new CommandCompiler(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $commandCompiler->compile();

        $dom = new DOMDocument;
        $this->assertTrue($dom->loadXML($qbxml));

        $xpath = new DOMXpath($dom);
        $requestQuery = $xpath->query('//QBXML/QBXMLMsgsRq/*');

        $this->assertGreaterThan(0, $requestQuery->length);
    }

    public function testCommandCompilerCompilesUnprocessedQuickbooksQueueElementsOnly()
    {
        $actionClasses = QuickbooksEnqueuer::getActionClasses(QuickbooksEnqueuer::ACTION_HOST_QUERY);

        // Create a new QuickbooksQueue entity but set it as processed.
        // This ensures that it will not be picked up to process again.
        $quickbooksQueue = new QuickbooksQueue;
        $quickbooksQueue->setApplication(static::$fixtures['application'])
            ->setProcessed(new DateTime)
            ->setCommand($actionClasses[0])
            ->setPersister($actionClasses[1]);

        $entityManager = $this->entityManager;
        $entityManager->persist($quickbooksQueue);
        $entityManager->flush($quickbooksQueue);

        $commandCompiler = new CommandCompiler(
            $this->entityManager,
            static::$fixtures['application'],
            static::$kernel->getContainer()->get('templating')
        );

        $qbxml = $commandCompiler->compile();

        $dom = new DOMDocument;
        $this->assertTrue($dom->loadXML($qbxml));

        $xpath = new DOMXpath($dom);
        $requestQuery = $xpath->query('//QBXML/QBXMLMsgsRq/*');

        $this->assertEquals(0, $requestQuery->length);
    }

}
