<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;
use MajorApi\AppBundle\Entity\Registration;
use MajorApi\AppBundle\Form\Type\RegistrationType;

use Symfony\Component\Security\Core\SecurityContext;

class WebAuthenticationController extends WebController
{

    public function signInAction()
    {
        // This displays the sign in form. Symfony itself handles
        // authenticating the account and setting the appropriate session.
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        if ($error) {
            $message = $this->get('translator')->trans($error->getMessage());
            $this->setErrorMessage($message);
        }

        return $this->render('MajorApiAppBundle:WebAuthentication:sign-in.html.twig');
    }

    public function signInOrRegisterAction($targetPath=null)
    {
        $registrationForm = $this->createForm(new RegistrationType, new Registration)
            ->createView();

        $parameters = [
            'targetPath' => $targetPath,
            'registrationForm' => $registrationForm
        ];

        return $this->render('MajorApiAppBundle:WebAuthentication:sign-in-or-register.html.twig', $parameters);
    }

}
