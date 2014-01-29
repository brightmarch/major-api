<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\Mixin\GetterMixin;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\HttpFoundation\Response;

class WebApplicationWebConnectorController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    use GetterMixin;

    /** @Secure(roles="ROLE_ACCOUNT") */
    public function downloadAction()
    {
        // This controller does not extend the normal
        // WebController class because we do not want any of the
        // check for a connected application to happen.
        $application = $this->getUser()->getPrimaryApplication();

        $qbwcTemplate = __DIR__ . '/../Resources/data/majorapi.quickbooks.template.qwc';

        $qbwc = file_get_contents($qbwcTemplate);
        $qbwc = sprintf(
            $qbwc,
            $application->getUsername(),
            $application->getQuickbooksOwnerId(),
            $application->getQuickbooksFileId()
        );

        $filename = sprintf('attachment; filename="web-connector-%s.qwc"', $application->getUsername());

        $response = new Response($qbwc, 200);
        $response->headers->set('Content-Type', 'application/xml');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('Content-Disposition', $filename);

        return $response;
    }

}
