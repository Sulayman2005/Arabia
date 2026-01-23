<?php

namespace App\Tests\Api;

final class CommandeSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testUserCannotAccessCommandesCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/commandes', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessCommandesCollection(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('GET', '/api/commandes', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }

    public function testUserCanAccessCommandeItemWhenAuthenticated(): void
    {
        // On évite un ID fixe : on récupère une commande existante en admin.
        $adminToken = $this->loginAndGetToken('admin@test.com', 'password');

        $response = static::createClient()->request('GET', '/api/commandes', [
            'headers' => $this->authHeader($adminToken, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseIsSuccessful();

        $data = $response->toArray(false);
        $items = $data['hydra:member'] ?? [];

        if (!is_array($items) || count($items) === 0) {
            $this->markTestSkipped('Aucune commande en base test (ajoute une fixture Commande ou crée-en une).');
        }

        $iri = $items[0]['@id'] ?? null;

        $this->assertIsString($iri, 'Le premier élément doit contenir un @id (IRI).');
        $this->assertNotSame('', $iri, 'Le @id (IRI) ne doit pas être vide.');

        $userToken = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', $iri, [
            'headers' => $this->authHeader($userToken, [
                'Accept' => 'application/json',
            ]),
        ]);

        $this->assertResponseIsSuccessful(); // 200 si item accessible aux utilisateurs authentifiés
    }
}
