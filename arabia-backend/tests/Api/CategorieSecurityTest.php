<?php

namespace App\Tests\Api;

final class CategorieSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testGetCategoriesIsPublic(): void
    {
        static::createClient()->request('GET', '/api/categories', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }

    public function testUserCannotCreateCategorie(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('POST', '/api/categories', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
            'json' => [], // payload invalide, mais on teste le droit d'accès
        ]);

        // Selon ta config API Platform/Security ça peut être 403 ou 401.
        // Si tu es sûr que user est authentifié => 403 est OK.
        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminReachesValidationOnCreateCategorie(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('POST', '/api/categories', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
            'json' => [], // vide -> admin autorisé => 422 attendu (validation)
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
