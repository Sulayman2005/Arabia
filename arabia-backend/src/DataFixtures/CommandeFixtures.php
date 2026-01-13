<?php

namespace App\DataFixtures;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommandeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // On associe les commandes uniquement à tes 2 users : admin / user
        $users = [
            $this->getReference('user_admin', Utilisateur::class),
            $this->getReference('user_user', Utilisateur::class),
        ];

        for ($i = 0; $i < 10; $i++) {
            $commande = new Commande();
            $commande->setDateCommande(new \DateTime());
            $commande->setStatut('en cours');
            $commande->setTotal('0.00');

            // Alterne (ou random) entre admin et user
            $commande->setUtilisateur($users[$i % 2]);

            $manager->persist($commande);
            $this->addReference('commande_'.$i, $commande);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
        ];
    }
}
