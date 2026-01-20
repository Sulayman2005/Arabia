<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

final class CommandeSecurityTest extends ApiTestCase
{
    use ApiHelperTrait;

    public function testUserCannotAccessCommandesCollection(): void
    {
        $token = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', '/api/commandes', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessCommandesCollection(): void
    {
        $token = $this->loginAndGetToken('admin@test.com', 'password');

        static::createClient()->request('GET', '/api/commandes', [
            'headers' => $this->authHeader($token),
        ]);

        $this->assertResponseIsSuccessful(); // 200
    }

    public function testUserCanAccessCommandeItemWhenAuthenticated(): void
    {
        // On teste juste "route item accessible si connecté".
        // Pour éviter de dépendre d'un ID fixe, on prend le 1er élément de la collection en admin.
        $adminToken = $this->loginAndGetToken('admin@test.com', 'password');

        $response = static::createClient()->request('GET', '/api/commandes', [
            'headers' => $this->authHeader($adminToken),
        ]);

        $this->assertResponseIsSuccessful();
        $data = $response->toArray(false);

        // API Platform JSON-LD: items dans "hydra:member"
        $items = $data['hydra:member'] ?? [];

        if (count($items) === 0) {
            $this->markTestSkipped('Aucune commande en base test (charge une fixture commande ou crée-en une).');
        }

        // IRI exemple: "/api/commandes/1"
        $iri = $items[0]['@id'] ?? null;
        $this->assertNotNull($iri);

        $userToken = $this->loginAndGetToken('user@test.com', 'password');

        static::createClient()->request('GET', $iri, [
            'headers' => $this->authHeader($userToken),
        ]);

        $this->assertResponseIsSuccessful(); // 200 si Get = IS_AUTHENTICATED_FULLY
    }
}
