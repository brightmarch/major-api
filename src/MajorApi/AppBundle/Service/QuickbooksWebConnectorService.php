<?php

namespace MajorApi\AppBundle\Service;

use MajorApi\AppBundle\Entity\Application;
use MajorApi\AppBundle\Library\Quickbooks\CommandCompiler;
use MajorApi\AppBundle\Library\Quickbooks\ResponseEnqueuer;

use \StdClass;

class QuickbooksWebConnectorService
{

    /** @var ContainerInterface */
    private $container;

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @const string */
    const AUTHENTICATION_ERROR = 'nvu';

    /** @const string */
    const VERSION = '0.0.8';

    public function __construct($container)
    {
        $this->container = $container;
        $this->entityManager = $container->get('doctrine')->getManager();
    }

    public function authenticate(StdClass $request)
    {
        $token = self::AUTHENTICATION_ERROR;

        $search = [
            'status' => Application::enabledFlag(),
            'username' => $request->strUserName,
            'apiKey' => $request->strPassword
        ];

        $application = $this->entityManager
            ->getRepository('MajorApiAppBundle:Application')
            ->findOneBy($search);

        if ($application) {
            $this->container->get('majorapi_activity_manager_service')
                ->setAccount($application->getAccount())
                ->saveMessage($this->getActivitySubject(), "Successfully authenticated request from QuickBooks WebConnector.");

            $token = $application->getQuickbooksToken();
        }

        $response = [
            'authenticateResult' => [$token, '']
        ];

        return $response;
    }

    public function sendRequestXML(StdClass $request)
    {
        $qbxml = '';

        $application = $this->entityManager
            ->getRepository('MajorApiAppBundle:Application')
            ->findOneByQuickbooksToken($request->ticket);

        if ($application) {
            $commandCompiler = new CommandCompiler(
                $this->entityManager,
                $application,
                $this->container->get('templating')
            );

            $qbxml = $commandCompiler->compile();

            $this->container->get('majorapi_activity_manager_service')
                ->setAccount($application->getAccount())
                ->saveMessage($this->getActivitySubject(), "Successfully sent QBXML from Major to QuickBooks.");
        }

        return ['sendRequestXMLResult' => $qbxml];
    }

    public function receiveResponseXML(StdClass $request)
    {
        $percentageFinished = 100;

        $application = $this->entityManager
            ->getRepository('MajorApiAppBundle:Application')
            ->findOneByQuickbooksToken($request->ticket);

        if ($application) {
            $resqueDsn = $this->container->getParameter('resque_dsn');

            $responseEnqueuer = new ResponseEnqueuer($this->entityManager, $application, $resqueDsn);
            $responseEnqueuer->enqueue($request->response);

            $this->container->get('majorapi_activity_manager_service')
                ->setAccount($application->getAccount())
                ->saveMessage($this->getActivitySubject(), "Successfully received QBXML from QuickBooks and enqueued in Major.");
        }

        return ['receiveResponseXMLResult' => $percentageFinished];
    }

    public function clientVersion(StdClass $request)
    {
        return ['strWarning' => ''];
    }

    public function getLastError(StdClass $request)
    {
        // todo Implement this fully.
        return ['error' => ''];
    }

    public function getServerVersion(StdClass $request)
    {
        return ['strVersion' => self::VERSION];
    }

    public function serverVersion(StdClass $request)
    {
        return $this->getServerVersion($request);
    }

    public function closeConnection(StdClass $request)
    {
        return ['connection' => 'OK'];
    }

    public function connectionError(StdClass $request)
    {
        // todo Implement this fully.
        return ['connectionError' => ''];
    }

    private function getActivitySubject()
    {
        return 'QuickBooks WebConnector';
    }

}
