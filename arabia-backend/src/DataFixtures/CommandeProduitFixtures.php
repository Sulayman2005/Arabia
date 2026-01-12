<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\CommandeProduit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommandeProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 30; $i++) {
            $cp = new CommandeProduit();

            $cp->setCommande(
                $this->getReference('commande_'.random_int(0, 9), Commande::class)
            );

            $cp->setProduit(
                $this->getReference('produit_'.random_int(0, 19), Produit::class)
            );

            $cp->setQuantite(random_int(1, 3));

            $manager->persist($cp);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CommandeFixtures::class,
            ProduitFixtures::class,
        ];
    }
}
