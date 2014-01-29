<?php

namespace MajorApi\AppBundle\Tests\Controller;

use MajorApi\AppBundle\Tests\Mixin\FunctionalMixin;
use MajorApi\AppBundle\Tests\TestCase;

class ApiTestCase extends TestCase
{

    use FunctionalMixin;

    public function createApiRequestHeaders()
    {
        // Create the correct HTTP headers for successfully navigating the MajorApi API.
        $headers = [
            'PHP_AUTH_USER' => static::$fixtures['application']->getUsername(),
            'PHP_AUTH_PW' => static::$fixtures['application']->getApiKey(),
            'HTTP_ACCEPT' => 'application/json'
        ];

        return $headers;
    }

}
