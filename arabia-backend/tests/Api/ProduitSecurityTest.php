<?php

namespace App\Tests\Api;
use App\Tests\Api\ApiHelperTrait;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class ProduitSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testGetProduitsIsPublic(): void
    {
        static::createClient()->request('GET', '/api/produits');
        $this->assertResponseIsSuccessful(); // 200
    }

    public function testUserCannotCreateProduit(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('POST', '/api/produits', [
            'headers' => $this->authHeader($token),
            'json' => [], // volontairement vide : on teste la permission, pas la validation
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminReachesValidationOnCreateProduit(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('POST', '/api/produits', [
            'headers' => $this->authHeader($token),
            'json' => [], // vide -> doit passer la security et tomber en validation
        ]);

        // Si admin est autorisé, tu ne dois PAS avoir 403
        // Normalement tu auras 422 (validation), ce qui prouve que la route est accessible en admin.
        $this->assertResponseStatusCodeSame(422);
    }
}
