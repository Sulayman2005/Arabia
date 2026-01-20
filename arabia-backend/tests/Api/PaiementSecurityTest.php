<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class PaiementSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testUserCannotAccessPaiementsCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/paiements', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessPaiementsCollection(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('GET', '/api/paiements', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }
}
