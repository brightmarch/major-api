<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;
use MajorApi\AppBundle\Entity\Account;
use MajorApi\AppBundle\Entity\Registration;
use MajorApi\AppBundle\Exception\WebException;
use MajorApi\AppBundle\Form\Type\RegistrationType;
use MajorApi\AppBundle\Library\MajorApi\ApplicationCreator;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class WebRegistrationController extends WebController
{

    public function indexAction()
    {
        $view = 'MajorApiAppBundle:WebRegistration:index.html.twig';

        $registrationForm = $this->createForm(new RegistrationType, new Registration)
            ->createView();

        $parameters = [
            'registrationForm' => $registrationForm
        ];

        return $this->render($view, $parameters);
    }

    public function processAction()
    {
        $redirectRoute = 'majorapi_web_registration';

        // The Registration entity exists so the form can be created properly.
        // The Registration entity is then hydrated from the form and copied over
        // to the Account entity.
        $registration = new Registration;
        $registrationForm = $this->createForm(new RegistrationType, $registration)
            ->bind($this->getRequest());

        if (!$registrationForm->isValid()) {
            $message = "Sorry, your registration can not be processed at this time.";
            throw new WebException($message, $redirectRoute);
        }

        // Ensure the email address is unique.
        $account = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:Account')
            ->findOneByEmail($registration->getEmail());

        if ($account) {
            $message = sprintf("Sorry, an account with the email address %s already exists. Please try registering with a different email address.", $account->getEmail());
            throw new WebException($message, $redirectRoute);
        }

        // Hydrate the new Account entity from the Registration entity.
        $account = new Account;
        $account->setFirstName($registration->getFirstName())
            ->setLastName($registration->getLastName())
            ->setEmail($registration->getEmail())
            ->setPlanAmount($this->getContainerParameter('plan_amount'))
            ->setTransactionRate($this->getContainerParameter('transaction_rate'));

        // Hash the password (uses bcrypt currently).
        if ($registration->hasPassword()) {
            $passwordHash = $this->get('security.encoder_factory')
                ->getEncoder($account)
                ->encodePassword($registration->getPassword(), $account->getSalt());

            $account->setPasswordHash($passwordHash);
        }

        // Validate this entity for the create validation group.
        $accountViolations = $this->getValidator()
            ->validate($account, ['create']);

        if ($accountViolations->count() > 0) {
            $message = "Sorry, your account could not be created at this time. Please ensure all fields are filled in, and you have provided a valid email address.";
            throw new WebException($message, $redirectRoute);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($account);
        $entityManager->flush($account);

        // Now, create and configure an application for this account.
        $applicationCreator = new ApplicationCreator($this->getContainer(), $account);
        $applicationCreator->persist();

        // Record an activity welcoming them to Major.
        $activityMessage = "Welcome to Major, %s.";
        $this->get('majorapi_activity_manager_service')
            ->setAccount($account)
            ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $account->getFirstName()));

        // Now that the account is generated, authenticate them and redirect them
        // to the wizard to create a new application.
        $credentials = null;
        $providerKey = 'secured_area'; // This is configured in security.yml

        $token = new UsernamePasswordToken($account, $credentials, $providerKey, $account->getRoles());
        $this->get('security.context')->setToken($token);

        return $this->redirect($this->generateUrl('majorapi_web_application_wizard_index'));
    }

    public function getActivitySubject()
    {
        return 'Account Created';
    }

}
