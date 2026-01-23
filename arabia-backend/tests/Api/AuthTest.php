<?php

namespace App\Tests\Api;

use App\Tests\Api\ApiTestCase;


final class AuthTest extends ApiTestCase
{
    public function testLogin(): void
    {
        $response = static::createClient()->request('POST', '/api/login', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => 'admin@test.com',
                'password' => 'password',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = $response->toArray(false);

        $this->assertArrayHasKey('token', $data, 'La réponse /api/login doit contenir un token JWT.');
        $this->assertIsString($data['token']);
        $this->assertNotSame('', $data['token']);
    }

    public function testWrongPasswordReturns401(): void
    {
        static::createClient()->request('POST', '/api/login', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => 'admin@test.com',
                'password' => 'falsepassword',
            ],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }
}
