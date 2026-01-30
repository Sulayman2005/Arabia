<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommandeProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Commande $commande0 */
        $commande0 = $this->getReference('commande_0', Commande::class);

        /** @var Commande $commande1 */
        $commande1 = $this->getReference('commande_1', Commande::class);

        // ✅ Liste de tes 6 produits (refs)
        $refs = [
            'produit_musc_royal',
            'produit_amber_tears',
            'produit_black_saffron',
            'produit_desert_vanille',
            'produit_imperial_oud',
            'produit_rose_divine',
        ];

        $this->addLigne($manager, $commande0, $this->getReference($refs[0], Produit::class), 1);
        $this->addLigne($manager, $commande0, $this->getReference($refs[2], Produit::class), 2);

        $this->addLigne($manager, $commande1, $this->getReference($refs[1], Produit::class), 1);
        $this->addLigne($manager, $commande1, $this->getReference($refs[3], Produit::class), 1);
        $this->addLigne($manager, $commande1, $this->getReference($refs[5], Produit::class), 1);

        $manager->flush();
    }

    private function addLigne(ObjectManager $manager, Commande $commande, Produit $produit, int $quantite): void
    {
        $cp = new CommandeProduit();
        $cp->setCommande($commande);
        $cp->setProduit($produit);
        $cp->setQuantite($quantite);

        $manager->persist($cp);
    }

    public function getDependencies(): array
    {
        return [
            CommandeFixtures::class,
            ProduitFixtures::class,
        ];
    }
}
