<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $noms = ['Parfums', 'Musc', 'Coffrets', 'Accessoires'];

        foreach ($noms as $index => $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $categorie->setDescription('Description de la catégorie ' . $nom);

            $manager->persist($categorie);
            $this->addReference('categorie_'.$index, $categorie);
        }

        $manager->flush();
    }
}
