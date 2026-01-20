<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class AuthTest extends ApiTestCase
{
    public function testLogin(): void
    {
        $response = static::createClient()->request('POST', '/api/login', [
            'json' => [
                'email' => 'admin@test.com',
                'password' => 'password',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);

        $data = $response->toArray(false);

        $this->assertArrayHasKey('token', $data);
        $this->assertNotEmpty($data['token']); // token JWT non vide
    }

    public function testfauxmotdepasse(): void
    {
        static::createClient()->request('POST', '/api/login', [
            'json' => [
                'email' => 'admin@test.com',
                'password' => 'falsepassword',
            ],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }
}
