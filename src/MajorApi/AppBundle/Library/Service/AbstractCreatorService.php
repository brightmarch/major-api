<?php

namespace MajorApi\AppBundle\Library\Service;

use MajorApi\AppBundle\Library\Service\AbstractService;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Mixin\GetterMixin;
use MajorApi\AppBundle\Library\Service\Mixin\PersistenceMixin;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractCreatorService extends AbstractService
{

    use GetterMixin;
    use PersistenceMixin;

    /** @var MajorApi\AppBundle\Library\Service\DataBridge */
    private $dataBridge;

    /** @var Symfony\Component\Validator\Validator */
    private $validator;

    public function __construct(ContainerInterface $container, DataBridge $dataBridge)
    {
        parent::__construct($container);

        $this->dataBridge = $dataBridge;
        $this->validator = $this->getContainer()->get('validator');
    }

    public function getValidationGroups()
    {
        return [];
    }

    abstract public function persist();
    abstract public function getEntity();
    abstract public function getInvalidException();

}
