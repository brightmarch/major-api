<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\Mixin\GetterMixin;
use MajorApi\AppBundle\Entity\Application;
use MajorApi\AppBundle\Library\Service\DataBridge;

use Brightmarch\RestEasy\Controller\Mixin\HttpAuthorizationMixin;
use Brightmarch\RestEasy\Controller\Mixin\HttpJsonMiddlewareMixin;
use Brightmarch\RestEasy\Exception\HttpUnauthorizedException;

abstract class ApiController extends \Brightmarch\RestEasy\Controller\Controller
{

    use GetterMixin;
    use HttpAuthorizationMixin;
    use HttpJsonMiddlewareMixin;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /** @var string */
    private $rawPayload = null;

    public function resourceRequiresAuthorization()
    {
        // If this method is called, the calling method requires valid
        // HTTP authorization headers for the method to run. If that
        // data is provided, the MajorApi application is loaded.
        $this->parseAuthorizationHeader();

        $search = [
            'status' => Application::enabledFlag(),
            'username' => $this->getAuthorizationHeaderKey('username'),
            'apiKey' => $this->getAuthorizationHeaderKey('apiKey')
        ];

        $this->application = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:Application')
            ->findOneBy($search);

        // End any attempt at access right here.
        if (!$this->application) {
            throw new HttpUnauthorizedException("Please specify a valid application username and API key for access to Major.");
        }

        return true;
    }

    public function getRawPayload()
    {
        // In production, the file_get_contents() call below can only be
        // executed once, so the data it returns is saved so this method
        // can be called multiple times and return the same data each time.
        if (empty($this->rawPayload)) {
            $request = $this->getRequest()->request;

            if ($request->has('json')) {
                $this->rawPayload = $request->get('json');
            } else {
                $this->rawPayload = file_get_contents('php://input');
            }
        }

        return $this->rawPayload;
    }

    public function getAccount()
    {
        return $this->getApplication()->getAccount();
    }

    public function getApplication()
    {
        return $this->application;
    }

    public function getApplicationId()
    {
        return (int)$this->getApplication()->getId();
    }

    public function getServiceDataBridge()
    {
        $dataBridge = new DataBridge($this->getRequest()->request->all());

        return $dataBridge;
    }

    public function getActivityManagerService()
    {
        $service = $this->get('majorapi_activity_manager_service');
        $service->setAccount($this->getAccount());

        return $service;
    }

    abstract public function getKey();
    abstract public function getActivitySubject();

}
