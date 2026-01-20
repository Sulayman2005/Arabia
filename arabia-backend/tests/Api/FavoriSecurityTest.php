<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class FavoriSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testFavorisIsDeniedWithoutToken(): void
    {
        static::createClient()->request('GET', '/api/favoris');
        $this->assertResponseStatusCodeSame(401);
    }

    public function testUserCanAccessFavorisCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/favoris', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }
}
