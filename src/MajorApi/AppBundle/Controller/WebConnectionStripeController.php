<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;
use MajorApi\AppBundle\Entity\QuickbooksItem;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Quickbooks\ItemNonInventoryCreatorService;
use MajorApi\AppBundle\Exception\WebException;

use \Requests;

class WebConnectionStripeController extends WebController
{

    /** @const string */
    const STRIPE_CONNECT_AUTHORIZE_URL = 'https://connect.stripe.com/oauth/authorize';

    /** @const string */
    const STRIPE_CONNECT_TOKEN_URL = 'https://connect.stripe.com/oauth/token';

    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Fully authenticated users get the URL directly to Stripe Connect.
            $stripeConnectAuthorizeUrl = $this->getStripeConnectAuthorizeUrl();
        } else {
            // Otherwise, we redirect them to the sign in / register page.
            // If they sign in, they are automatically redirected directly to Stripe Connect.
            // If they register, they can go to Stripe Connect after connecting with QuickBooks
            // and entering payment information.
            $stripeConnectAuthorizeUrl = $this->generateUrl('majorapi_web_connect_with_stripe_authenticate');
        }

        $parameters = [
            'stripeConnectAuthorizeUrl' => $stripeConnectAuthorizeUrl
        ];

        return $this->render('MajorApiAppBundle:WebConnection:stripe.html.twig', $parameters);
    }

    public function connectAction()
    {
        $redirectRoute = 'majorapi_web_connect_with_stripe';
        $query = $this->getRequest()->query;

        // First ensure there is a code parameter coming from Stripe.
        if (!$query->has('code')) {
            $message = "Sorry, the connection with Stripe could not be made successfully.";
            throw new WebException($message, $redirectRoute);
        }

        $stripeCode = $query->get('code');

        // Determine if we have an authenticated user. If they are signed in, make a request
        // to Stripe to get the final tokens.
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Make a POST request to Stripe to get the connection information.
            $oauthData = [
                'client_secret' => $this->getContainerParameter('stripe_secret_key'),
                'code' => $stripeCode,
                'grant_type' => 'authorization_code'
            ];

            $response = Requests::post(self::STRIPE_CONNECT_TOKEN_URL, [], $oauthData);

            if (!$response->success) {
                $message = "Sorry, the OAuth flow with Stripe Connect could not be completed successfully.";
                throw new WebException($message, $redirectRoute);
            }

            // Now that we know we have a successful response, decode it and get the proper values:
            // access_token, refresh_token, stripe_publishable_key, stripe_user_id
            $stripeTokens = json_decode($response->body);

            // This is simple, just update their account, add a message, and they're done.
            $account = $this->getAccount();
            $account->setStripeAccessToken($stripeTokens->access_token)
                ->setStripeRefreshToken($stripeTokens->refresh_token)
                ->setStripePublishableKey($stripeTokens->stripe_publishable_key)
                ->setStripeUserId($stripeTokens->stripe_user_id);

            $entityManager = $this->getEntityManager();
            $entityManager->persist($account);
            $entityManager->flush($account);

            // Create a new QuickBooks item for them. The item will be named StripeCharge
            // and have a value of .01. That way, all invoices being imported will reconcile
            // against that item.
            $dataBridge = new DataBridge([
                'name' => $this->getContainerParameter('stripe_item_name'),
                'price' => $this->getContainerParameter('stripe_item_price')
            ]);

            $service = new ItemNonInventoryCreatorService($this->getContainer(), $dataBridge);
            $service->setApplication($account->getPrimaryApplication());
            $service->persist();

            // Save a message saying they are connected to Stripe.
            $activityMessage = "You have successfully connected your Major account to Stripe!";
            $activityManagerService = $this->get('majorapi_activity_manager_service');
            $activityManagerService->setAccount($account)
                ->saveMessage($this->getActivitySubject(), $activityMessage);
        }

        return $this->redirect($this->generateUrl('majorapi_web_dashboard'));
    }

    public function authenticateAction()
    {
        $this->setErrorMessage("Please sign in or register to connect QuickBooks with Stripe.");

        $parameters = [
            'targetPath' => $this->getStripeConnectAuthorizeUrl()
        ];

        return $this->forward('MajorApiAppBundle:WebAuthentication:signInOrRegister', $parameters);
    }

    public function getActivitySubject()
    {
        return 'Connection: Stripe';
    }

    private function getStripeConnectAuthorizeUrl()
    {
        $query = [
            'response_type' => 'code',
            'scope' => 'read_write',
            'stripe_landing' => 'login',
            'client_id' => $this->getContainerParameter('stripe_client_id')
        ];

        $stripeConnectAuthorizeUrl = sprintf('%s?%s', self::STRIPE_CONNECT_AUTHORIZE_URL, http_build_query($query));

        return $stripeConnectAuthorizeUrl;
    }

}
