<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksItem;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\AbstractCreatorService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemExistsException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemInvalidCreationException;

abstract class ItemCreatorService extends AbstractCreatorService
{

    /** @var MajorApi\AppBundle\Entity\QuickbooksItem */
    private $quickbooksItem;

    public function persist()
    {
        $this->hydrateQuickbooksItem()
            ->checkNameIsUnique()
            ->persistEntity();

        return $this->getEntity();
    }

    public function getEntity()
    {
        if (!$this->quickbooksItem) {
            $this->quickbooksItem = new QuickbooksItem;
        }

        return $this->quickbooksItem;
    }

    public function getInvalidException()
    {
        return ItemInvalidCreationException::create();
    }

    abstract public function getItemType();

    private function hydrateQuickbooksItem()
    {
        $dataBridge = $this->getDataBridge();

        // These are explicitly set so no data can leak in by accident.
        $this->getEntity()
            ->setApplication($this->getApplication())
            ->setType($this->getItemType())
            ->setName($dataBridge['name'])
            ->setFullname($dataBridge['fullname'])
            ->setPrice($dataBridge['price'])
            ->setDescription($dataBridge['description']);

        return $this;
    }

    private function checkNameIsUnique()
    {
        // This specifically does not use the ItemFinderService
        // because that service will throw an exception if the item
        // is _not_ found, which we do not want to try to catch and handle.
        $quickbooksName = $this->getEntity()->getName();

        $search = [
            'applicationId' => $this->getApplicationId(),
            'name' => $quickbooksName
        ];

        $quickbooksItem = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:QuickbooksItem')
            ->findOneBy($search);

        if ($quickbooksItem) {
            throw ItemExistsException::create($quickbooksItem->getName());
        }

        return $this;
    }

}
