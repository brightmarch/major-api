<?php

namespace MajorApi\AppBundle\Controller\Mixin;

trait MessagingMixin
{

    public function setSuccessMessage($message)
    {
        return $this->setFlashMessage('success', $message);
    }

    public function setErrorMessage($message)
    {
        return $this->setFlashMessage('error', $message);
    }

    private function setFlashMessage($key, $message)
    {
        $this->get('session')
            ->getFlashBag()
            ->add($key, $message);

        return true;
    }

}
