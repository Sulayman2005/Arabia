<?php

// On déclare le namespace correspondant au dossier tests/Api
namespace App\Tests\Api;

// Cette classe contient tous nos tests CRUD minimum
// Elle hérite de ApiTestCase (qui contient nos helpers JWT)
final class CrudMinimumTest extends ApiTestCase
{
    /**
     * 🔐 Méthode utilitaire : récupère un token JWT admin
     * Elle appelle loginAndGetToken() défini dans ApiHelperTrait
     */
    private function adminToken(): string
    {
        return $this->loginAndGetToken('admin@test.com', 'password');
    }

    /**
     * 📂 Récupère l'IRI (ex: /api/categories/6) d'une catégorie existante
     * API Platform exige un IRI pour les relations (pas un simple id)
     */
    private function firstCategorieIri(string $token): string
    {
        // On fait un GET /api/categories avec authentification
        $res = static::createClient()->request('GET', '/api/categories', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json'
            ]),
        ]);

        // On vérifie que la réponse est bien 200
        $this->assertResponseIsSuccessful();

        // On transforme la réponse JSON en tableau PHP
        $data = $res->toArray(false);

        // On vérifie que la clé "member" existe (liste des catégories)
        $this->assertArrayHasKey('member', $data);
        $this->assertNotEmpty($data['member']);

        // On retourne l'IRI de la première catégorie
        return $data['member'][0]['@id'];
    }

    /**
     * 🆕 Crée un produit valide et retourne son IRI
     * On l'utilise pour pouvoir ensuite le modifier (PATCH)
     */
    private function createProduitAndGetIri(string $token): string
    {
        // On récupère une catégorie valide
        $categorieIri = $this->firstCategorieIri($token);

        // On envoie un POST /api/produits
        $res = static::createClient()->request('POST', '/api/produits', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json'
            ]),
            'json' => [
                'nom' => 'Produit Test',
                // ⚠️ Minimum 10 caractères sinon validation 422
                'description' => 'Description OK',
                'prix' => '10',
                'stock' => 1,
                'image' => 'test.png',

                // Relation obligatoire -> IRI
                'categorie' => $categorieIri,

                // ⚠️ Obligatoire dans ton entité
                'dateAjout' => (new \DateTimeImmutable('now'))
                    ->format(\DateTimeInterface::ATOM),
            ],
        ]);

        // On vérifie que la création retourne bien 201
        $this->assertResponseStatusCodeSame(201);

        // On récupère la réponse
        $created = $res->toArray(false);

        // On vérifie que l'IRI existe
        $this->assertArrayHasKey('@id', $created);

        // On retourne l'IRI du produit créé
        return $created['@id'];
    }

    /**
     * ✅ TEST READ : Vérifie que GET /api/produits fonctionne
     */
    public function testGetProduits200(): void
    {
        static::createClient()->request('GET', '/api/produits', [
            'headers' => ['Accept' => 'application/ld+json'],
        ]);

        // On vérifie que la réponse est 200
        $this->assertResponseIsSuccessful();
    }

    /**
     * ✅ TEST CREATE : Admin peut créer un produit
     */
    public function testAdminCanCreateProduit201(): void
    {
        $token = $this->adminToken();

        // Cette méthode vérifie déjà le 201
        $this->createProduitAndGetIri($token);
    }

    /**
     * ✅ TEST VALIDATION : Création sans nom -> 422
     */
    public function testAdminCannotCreateProduit422WhenNomMissing(): void
    {
        $token = $this->adminToken();
        $categorieIri = $this->firstCategorieIri($token);

        static::createClient()->request('POST', '/api/produits', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json'
            ]),
            'json' => [
                // ❌ nom manquant volontairement
                'description' => 'Description OK',
                'prix' => '10',
                'stock' => 1,
                'image' => 'test.png',
                'categorie' => $categorieIri,
                'dateAjout' => (new \DateTimeImmutable('now'))
                    ->format(\DateTimeInterface::ATOM),
            ],
        ]);

        // On vérifie que la validation bloque bien la requête
        $this->assertResponseStatusCodeSame(422);
    }

    /**
     * ✅ TEST UPDATE : Admin peut modifier un produit
     */
    public function testAdminCanPatchProduit200(): void
    {
        $token = $this->adminToken();

        // On crée d'abord un produit
        $produitIri = $this->createProduitAndGetIri($token);

        // On modifie son nom avec PATCH
        $res = static::createClient()->request('PATCH', $produitIri, [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json',
                // Obligatoire pour PATCH API Platform
                'Content-Type' => 'application/merge-patch+json',
            ]),
            'json' => [
                'nom' => 'Produit Updated',
            ],
        ]);

        // On vérifie que la réponse est 200
        $this->assertResponseIsSuccessful();

        // On vérifie que la modification a bien été prise en compte
        $updated = $res->toArray(false);
        $this->assertSame('Produit Updated', $updated['nom']);
    }

    /**
     * ✅ CRUD minimum sur Categorie :
     * - CREATE
     * - VALIDATION
     * - UPDATE
     */
    public function testCategorieCrudMinimum(): void
    {
        $token = $this->adminToken();

        // 🆕 CREATE
        $resCreate = static::createClient()->request('POST', '/api/categories', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json'
            ]),
            'json' => [
                'nom' => 'Categorie Test',
                // ⚠️ Obligatoire chez toi
                'description' => 'Description categorie',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        $created = $resCreate->toArray(false);
        $this->assertArrayHasKey('@id', $created);

        $categorieIri = $created['@id'];

        // ❌ VALIDATION (description manquante)
        static::createClient()->request('POST', '/api/categories', [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json'
            ]),
            'json' => [
                'nom' => 'Categorie Bad',
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);

        // ✏️ UPDATE
        $resPatch = static::createClient()->request('PATCH', $categorieIri, [
            'headers' => $this->authHeader($token, [
                'Accept' => 'application/ld+json',
                'Content-Type' => 'application/merge-patch+json',
            ]),
            'json' => [
                'nom' => 'Categorie Updated'
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $updated = $resPatch->toArray(false);
        $this->assertSame('Categorie Updated', $updated['nom']);
    }
}