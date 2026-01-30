<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $parfums = [
            [
                'ref' => 'produit_musc_royal',
                'nom' => 'Musc Royal',
                'description' => 'Un musc élégant, doux et intense. Signature raffinée et chaleureuse.',
                'prix' => '50',
                'stock' => 30,
                'image' => 'musc_royal.PNG',
                'categorie_ref' => 'categorie_0',
            ],
            [
                'ref' => 'produit_amber_tears',
                'nom' => 'Amber Tears',
                'description' => 'Un ambre profond et sensuel, avec une touche sucrée qui tient longtemps.',
                'prix' => '55',
                'stock' => 25,
                'image' => 'amber_tears.PNG',
                'categorie_ref' => 'categorie_1',
            ],
            [
                'ref' => 'produit_black_saffron',
                'nom' => 'Black Saffron',
                'description' => 'Safran noir épicé, mystérieux et puissant, pour une aura luxueuse.',
                'prix' => '60',
                'stock' => 20,
                'image' => 'black_saffron.PNG',
                'categorie_ref' => 'categorie_2',
            ],
            [
                'ref' => 'produit_desert_vanille',
                'nom' => 'Desert Vanille',
                'description' => 'Vanille chaude et gourmande, sublimée par des notes orientales douces.',
                'prix' => '45',
                'stock' => 35,
                'image' => 'desert_vanille.PNG',
                'categorie_ref' => 'categorie_3',
            ],
            [
                'ref' => 'produit_imperial_oud',
                'nom' => 'Imperial Oud',
                'description' => 'Oud noble et boisé, riche et majestueux. Un parfum de caractère.',
                'prix' => '75',
                'stock' => 15,
                'image' => 'imperial_oud.PNG',
                'categorie_ref' => 'categorie_2',
            ],
            [
                'ref' => 'produit_rose_divine',
                'nom' => 'Rose Divine',
                'description' => 'Rose veloutée et lumineuse, équilibrée par des accords musqués raffinés.',
                'prix' => '52',
                'stock' => 28,
                'image' => 'rose_divine.PNG',
                'categorie_ref' => 'categorie_1',
            ],
        ];

        foreach ($parfums as $p) {
            $produit = new Produit();
            $produit->setNom($p['nom']);
            $produit->setDescription($p['description']);
            $produit->setPrix($p['prix']);
            $produit->setStock($p['stock']);
            $produit->setImage($p['image']);
            $produit->setDateAjout(new \DateTime());

            $produit->setCategorie(
                $this->getReference($p['categorie_ref'], Categorie::class)
            );

            $manager->persist($produit);
            $this->addReference($p['ref'], $produit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategorieFixtures::class];
    }
}
