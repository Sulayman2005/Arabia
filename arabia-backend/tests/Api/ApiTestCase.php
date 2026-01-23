<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase as ApiPlatformTestCase;

abstract class ApiTestCase extends ApiPlatformTestCase
{
    protected static ?bool $alwaysBootKernel = true;
}
