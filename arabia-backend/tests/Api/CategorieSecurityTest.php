<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class CategorieSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testGetCategoriesIsPublic(): void
    {
        static::createClient()->request('GET', '/api/categories');
        $this->assertResponseIsSuccessful(); // 200
    }

    public function testUserCannotCreateCategorie(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('POST', '/api/categories', [
            'headers' => $this->authHeader($token),
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminReachesValidationOnCreateCategorie(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('POST', '/api/categories', [
            'headers' => $this->authHeader($token),
            'json' => [], // vide -> si admin autorisé, ça tombe en 422 (validation)
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
