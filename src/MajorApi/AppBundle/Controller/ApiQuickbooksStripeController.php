<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Entity\QuickbooksStripeEvent;
use MajorApi\AppBundle\Library\Service\Exception\Exception as ServiceException;

use \ReflectionClass,
    \StdClass;

class ApiQuickbooksStripeController extends ApiController
{

    public function processAction()
    {
        $activityMessage = "Successfully received and processed the %s event from Stripe.";

        // Failed requests get a null response.
        // Because Stripe gets the response to this webhook, we really
        // don't need to give detailed reasons about why it failed. Thus,
        // exceptions are mostly not used and instead a 200 Ok response
        // is always returned.
        $eventId = null;

        // Get the payload JSON
        $stripeEventPayload = $this->getRawPayload();
        $stripeEvent = json_decode($stripeEventPayload);

        // If we fail to properly parse the Stripe event, just set it to
        // a default class and let the rest of the validation fail.
        if (!$stripeEvent) {
            $stripeEvent = new StdClass;
        }

        // Parse it to get the user_id, livemode and event_id.
        $hasUserId = property_exists($stripeEvent, 'user_id');
        $hasLivemode = property_exists($stripeEvent, 'livemode');
        $hasEventId = property_exists($stripeEvent, 'id');

        if ($hasUserId && $hasLivemode && $hasEventId) {
            $eventId = $stripeEvent->id;

            // Look up the event to see if it was found.
            // We do not want to process the same event twice.
            $quickbooksStripeEvent = $this->getEntityManager()
                ->getRepository('MajorApiAppBundle:QuickbooksStripeEvent')
                ->findOneByStripeEventId($eventId);

            if (!$quickbooksStripeEvent) {
                // Attempt to find the account based on the user_id.
                $account = $this->getEntityManager()
                    ->getRepository('MajorApiAppBundle:Account')
                    ->findOneByStripeUserId($stripeEvent->user_id);

                if ($account) {
                    // Save the event data.
                    $quickbooksStripeEvent = new QuickbooksStripeEvent;
                    $quickbooksStripeEvent->setAccount($account)
                        ->setStripeEventId($eventId)
                        ->setStripeEventPayload($stripeEventPayload)
                        ->setStripeEventType($stripeEvent->type);

                    $entityManager = $this->getEntityManager();
                    $entityManager->persist($quickbooksStripeEvent);
                    $entityManager->flush($quickbooksStripeEvent);

                    if ($quickbooksStripeEvent->isProcessable()) {
                        // Manually build this because the parent method does not know how to
                        // get the ActivityManagerService properly since this API resource
                        // does not require HTTP authentication.
                        $activityManagerService = $this->get('majorapi_activity_manager_service');
                        $activityManagerService->setAccount($account);

                        $rc = new ReflectionClass($quickbooksStripeEvent->getProcessorClass());

                        try {
                            $processor = $rc->newInstance($this->getContainer(), $account, $stripeEvent);
                            $processor->process();

                            $activityManagerService->saveMessage(
                                $this->getActivitySubject(),
                                sprintf($activityMessage, $quickbooksStripeEvent->getStripeEventType())
                            );
                        } catch (ServiceException $e) {
                            $activityManagerService->saveWarning($this->getActivitySubject(), $e->getMessage());
                        }
                    }
                }
            }
        }

        return $this->renderResource('MajorApiAppBundle:ApiQuickbooks:stripe', ['eventId' => $eventId]);
    }

    public function getKey()
    {
        return 'api_quickbooks_stripe_process';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Stripe API';
    }

}
