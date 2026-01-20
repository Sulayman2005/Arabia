<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class CommandeProduitSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testUserCannotAccessCommandeProduitsCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/commande_produits', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessCommandeProduitsCollection(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('GET', '/api/commande_produits', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }
}
