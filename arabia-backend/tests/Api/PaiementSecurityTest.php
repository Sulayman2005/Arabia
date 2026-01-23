<?php

namespace App\Tests\Api;

final class PaiementSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testUserCannotAccessPaiementsCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/paiements', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessPaiementsCollection(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('GET', '/api/paiements', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }
}
