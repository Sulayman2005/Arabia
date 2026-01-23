<?php

namespace App\Tests\Api;

final class FavoriSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testFavorisIsDeniedWithoutToken(): void
    {
        static::createClient()->request('GET', '/api/favoris', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testUserCanAccessFavorisCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/favoris', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }
}
