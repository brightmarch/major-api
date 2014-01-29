<?php

namespace MajorApi\AppBundle\EventListener;

use MajorApi\AppBundle\Controller\WebController;
use MajorApi\AppBundle\Library\MajorApi\ApplicationCreator;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class WebActionListener
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Account */
    private $account;

    /** @var Symfony\Bundle\FrameworkBundle\Routing\Router */
    private $router;

    public function handleKernelController(FilterControllerEvent $event)
    {
        // Listens to controller events.
        if (!is_array($event->getController())) {
            return false;
        }

        $controller = $event->getController()[0];

        if ($controller instanceof WebController) {
            // If the user is fully signed in, check to see if they have an application.
            // If not, create one and configure it for them.
            $this->entityManager = $controller->getEntityManager();
            $this->router = $controller->get('router');

            if ($controller->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $this->account = $controller->getAccount();

                if (!$this->account->hasApplications()) {
                    // Create and configure an application for this account.
                    // This handles the case for older Major users who did not
                    // create an application when they registered.
                    $applicationCreator = new ApplicationCreator($controller->getContainer(), $this->account);
                    $applicationCreator->persist();
                }
            }
        }

        return true;
    }

    public function handleKernelResponse(FilterResponseEvent $event)
    {
        // If we have an authenticated user, who now is guaranteed to have an application,
        // check to see if the application is integrated with QuickBooks. If not,
        // route them through to the application wizard.
        if ($this->account) {
            // Refresh the account to ensure we get any new applications
            // because the application may have just been created for it.
            $this->entityManager->refresh($this->account);

            $response = null;
            $application = $this->account->getPrimaryApplication();

            if (!$application->isConnectedToWebConnector()) {
                $response = new RedirectResponse($this->router->generate('majorapi_web_application_wizard_index'), 301);
            }

            if ($response) {
                $response->setProtocolVersion('1.1');
                $event->setResponse($response);
            }
        }

        return true;
    }

}
