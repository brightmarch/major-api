<?php

namespace MajorApi\AppBundle\Library\Service\Mixin;

use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;

trait PersistenceMixin
{

    protected function persistEntity()
    {
        $this->validateEntity();

        $entityManager = $this->getEntityManager();

        try {
            $entityManager->beginTransaction();

                // Persist the actual entity first.
                $entityManager->persist($this->getEntity());
                $entityManager->flush($this->getEntity());

                // Enqueue the new entity so it can get bridged into QuickBooks.
                if ($this->hasQueueAction()) {
                    (new QuickbooksEnqueuer(
                        $this->getEntityManager(),
                        $this->getApplication(),
                        $this->getContainer()->getParameter('resque_dsn')
                    ))->enqueue($this->getQueueAction(), $this->getEntity()->getId());
                }

            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            throw $e;
        }

        return $this;
    }

    protected function validateEntity()
    {
        // A service can provide it's own validation groups to ensure the right data is valid.
        $violations = $this->getValidator()
            ->validate($this->getEntity(), $this->getValidationGroups());

        if ($violations->count() > 0) {
            // If there are violations then compile them to a single key/value
            // array that the exception can send back to the client. MAJORAPI-63
            $exceptionViolations = [];
            foreach ($violations as $violation) {
                $exceptionViolations[$violation->getPropertyPath()] = trim($violation->getMessage());
            }

            $exception = $this->getInvalidException()
                ->setViolations($exceptionViolations);

            throw $exception;
        }

        return true;
    }

}
