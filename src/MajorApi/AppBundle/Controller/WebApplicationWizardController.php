<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\Mixin\GetterMixin;
use MajorApi\AppBundle\Controller\Mixin\MessagingMixin;
use MajorApi\AppBundle\Entity\AccountBilling;
use MajorApi\AppBundle\Exception\WebException;
use MajorApi\AppBundle\Form\Type\AccountBillingType;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Stripe,
    Stripe_Customer,
    Stripe_Token,
    Stripe_Error;

class WebApplicationWizardController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    use GetterMixin;
    use MessagingMixin;

    /** @Secure(roles="ROLE_ACCOUNT") */
    public function indexAction()
    {
        $parameters = [
            'application' => $this->getAccount()->getPrimaryApplication()
        ];

        return $this->render('MajorApiAppBundle:WebApplicationWizard:index.html.twig', $parameters);
    }

    /** @Secure(roles="ROLE_ACCOUNT") */
    public function billingAction()
    {
        // Ensure they have connected to QuickBooks. This is normally
        // handled in the WebActionListener, but because this controller
        // is not operated on in that class, we have to manually ensure
        // the QuickBooks connection is made.
        $application = $this->getAccount()->getPrimaryApplication();
        if (!$application->isConnectedToWebConnector()) {
            $message = "Sorry, your application must be connected to QuickBooks before you can synchronize with Major.";
            throw new WebException($message, 'majorapi_web_application_wizard_index');
        }

        $accountBillingForm = $this->createForm(new AccountBillingType)
            ->createView();

        $parameters = [
            'account' => $this->getAccount(),
            'accountBillingForm' => $accountBillingForm
        ];

        return $this->render('MajorApiAppBundle:WebApplicationWizard:billing.html.twig', $parameters);
    }

    /** @Secure(roles="ROLE_ACCOUNT") */
    public function billingProcessAction()
    {
        $redirectRoute = 'majorapi_web_application_wizard_billing';

        $accountBilling = new AccountBilling;
        $accountBillingForm = $this->createForm(new AccountBillingType, $accountBilling)
            ->bindRequest($this->getRequest());

        if (!$accountBillingForm->isValid()) {
            $message = "Sorry, billing for your account could not be set up. Please ensure all fields are filled in, and you provided a valid credit card.";
            throw new WebException($message, $redirectRoute);
        }

        try {
            // Attempt to tokenize and save the credit card to Stripe.
            $creditCard = [
                'card' => [
                    'number' => $accountBilling->getCardNumber(),
                    'exp_month' => $accountBilling->getExpirationMonth(),
                    'exp_year' => $accountBilling->getExpirationYear(),
                    'cvc' => $accountBilling->getCvc()
                ]
            ];

            Stripe::setApiKey($this->getContainerParameter('stripe_secret_key'));
            $stripeToken = Stripe_Token::create($creditCard);

            $account = $this->getAccount();
            $account->setBillingToken($stripeToken->id)
                ->setBillingDigits($stripeToken->card->last4)
                ->setBillingType($stripeToken->card->type);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($account);
            $entityManager->flush($account);

            $message = "Thank you for becoming a Major customer. Your credit card ending in %s was successfully saved.";
            $this->setSuccessMessage(sprintf($message, $account->getBillingDigits()));

            return $this->redirect($this->generateUrl('majorapi_web_application_wizard_connect'));
        } catch (Stripe_Error $e) {
            $message = "Sorry, your credit card failed to authorize. Please try another credit card.";
            throw new WebException($message, $redirectRoute);
        }
    }

    /** @Secure(roles="ROLE_ACCOUNT") */
    public function connectAction()
    {
        // Not incredibly concerned about them knowing this URL and bypassing the
        // two previous steps. So not testing anything here yet.
        $parameters = [
            'stripeClientId' => $this->getContainerParameter('stripe_client_id'),
            'application' => $this->getAccount()->getPrimaryApplication()
        ];

        return $this->render('MajorApiAppBundle:WebApplicationWizard:connect.html.twig', $parameters);
    }

    public function getAccount()
    {
        return $this->getUser();
    }

}
