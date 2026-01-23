<?php

namespace App\Tests\Api;

final class UtilisateurSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testUserCannotAccessUsersCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/utilisateurs', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessUsersCollection(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('GET', '/api/utilisateurs', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }
}
