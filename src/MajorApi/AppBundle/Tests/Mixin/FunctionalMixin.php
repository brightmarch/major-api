<?php

namespace MajorApi\AppBundle\Tests\Mixin;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

trait FunctionalMixin
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var string */
    protected $fixturesDirectory;

    /** @var array */
    protected static $fixtures = [];

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();

        // Manually load and execute the fixtures. We do not use the command line arguments
        // because they do it once for the entire test run, and we want to do it for every test.
        $this->fixturesDirectory = realpath(__DIR__ . '/../Fixtures/');

        $loader = new ContainerAwareLoader(static::$kernel->getContainer());
        $loader->loadFromDirectory($this->fixturesDirectory);
        $fixtures = $loader->getFixtures();

        $executor = new ORMExecutor($this->entityManager, new ORMPurger($this->entityManager));
        $executor->execute($fixtures);

        // Automatically hydrate the fixtures so they can be used in the tests. As more fixtures
        // are added they will be automatically added to the the static::$fixtures array.
        $referenceRepository = $executor->getReferenceRepository();
        $referenceNames = array_keys($referenceRepository->getReferences());

        foreach ($referenceNames as $referenceName) {
            // The reference is fetched using getReference() rather than just the array from getReferences()
            // above because getReference() actually hydrates the object from the entity manager.
            static::$fixtures[$referenceName] = $referenceRepository->getReference($referenceName);
        }

        return true;
    }

    public function tearDown()
    {
        parent::tearDown();

        // Immediately closes the database connection because Doctrine
        // will leave it open and too many tests will cause Postgres to run out of available connections.
        $this->entityManager->getConnection()->close();

        return true;
    }

}
