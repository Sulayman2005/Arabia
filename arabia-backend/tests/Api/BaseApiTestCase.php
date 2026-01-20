<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

abstract class BaseApiTestCase extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = true;
}
