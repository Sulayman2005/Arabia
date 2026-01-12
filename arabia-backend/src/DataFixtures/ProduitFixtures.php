<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $produit = new Produit();
            $produit->setNom('Arabia ' . $faker->word());
            $produit->setDescription($faker->paragraph());
            $produit->setPrix((string) $faker->randomFloat(2, 15, 120));
            $produit->setStock($faker->numberBetween(5, 50));
            $produit->setImage('produit.jpg');
            $produit->setDateAjout(new \DateTime());

            $categorieIndex = $faker->numberBetween(0, 3);

            $produit->setCategorie(
                $this->getReference('categorie_'.$categorieIndex, Categorie::class)
            );

            $manager->persist($produit);
            $this->addReference('produit_'.$i, $produit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategorieFixtures::class];
    }
}
