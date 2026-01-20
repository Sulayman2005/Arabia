<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\Client;

trait ApiHelperTrait
{
    private function loginAndGetToken(string $email, string $password): string
    {
        $response = static::createClient()->request('POST', '/api/login', [
            'json' => ['email' => $email, 'password' => $password],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $data = $response->toArray(false);

        return $data['token'];
    }

    private function authHeader(string $token): array
    {
        return ['Authorization' => 'Bearer '.$token];
    }
}
