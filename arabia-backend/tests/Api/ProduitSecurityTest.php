<?php

namespace App\Tests\Api;

final class ProduitSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testGetProduitsIsPublic(): void
    {
        static::createClient()->request('GET', '/api/produits', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }

    public function testUserCannotCreateProduit(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('POST', '/api/produits', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
            'json' => [], // on teste la permission, pas la validation
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminReachesValidationOnCreateProduit(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('POST', '/api/produits', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
            'json' => [], // admin autorisé -> 422 attendu
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
