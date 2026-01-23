<?php

namespace App\Tests\Api;



trait ApiHelperTrait
{
    /**
     * Login via /api/login and return JWT token.
     */
    protected function loginAndGetToken(string $email, string $password): string
    {
        $response = static::createClient()->request('POST', '/api/login', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        // Plus souple qu'un 200 fixe (et plus clair si ça casse)
        $this->assertResponseIsSuccessful();

        // Si la réponse n'est pas un JSON valide, ça doit être explicite
        $data = $response->toArray(false);

        $this->assertIsArray($data, 'La réponse /api/login doit être un JSON objet.');
        $this->assertArrayHasKey('token', $data, 'La réponse /api/login doit contenir la clé "token".');
        $this->assertIsString($data['token'], 'Le token retourné par /api/login doit être une string.');
        $this->assertNotSame('', $data['token'], 'Le token retourné par /api/login ne doit pas être vide.');

        return $data['token'];
    }

    /**
     * Convenience helper to build auth headers.
     *
     * @param array<string,string> $headers
     * @return array<string,string>
     */
    protected function authHeader(string $token, array $headers = []): array
    {
        return array_merge($headers, [
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
}
