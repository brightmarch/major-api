<?php

namespace MajorApi\AppBundle\Library\Service\MajorApi;

use MajorApi\AppBundle\Entity\Activity;
use MajorApi\AppBundle\Library\Service\AbstractService;

class ActivityManagerService extends AbstractService
{

    public function saveMessage($subject, $message)
    {
        return $this->saveActivity(Activity::TYPE_MESSAGE, $subject, $message);
    }

    public function saveWarning($subject, $message)
    {
        return $this->saveActivity(Activity::TYPE_WARNING, $subject, $message);
    }

    public function saveAlert($subject, $message)
    {
        return $this->saveActivity(Activity::TYPE_ALERT, $subject, $message);
    }

    private function saveActivity($type, $subject, $message)
    {
        $activity = new Activity;
        $activity->setAccount($this->getAccount())
            ->setType($type)
            ->setSubject($subject)
            ->setMessage($message);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($activity);
        $entityManager->flush($activity);

        return $activity;
    }

}
