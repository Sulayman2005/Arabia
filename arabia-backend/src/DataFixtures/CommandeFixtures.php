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
        /** @var Utilisateur $user */
        $user = $this->getReference('user_user', Utilisateur::class);

        // Commande 0
        $commande1 = new Commande();
        $commande1->setUtilisateur($user);
        $commande1->setDateCommande(new \DateTime('-2 days'));
        $commande1->setStatut('payee');

        $commande1->setTotal('0'); 

        $manager->persist($commande1);
        $this->addReference('commande_0', $commande1);

        // Commande 1
        $commande2 = new Commande();
        $commande2->setUtilisateur($user);
        $commande2->setDateCommande(new \DateTime('-1 day'));
        $commande2->setStatut('en_preparation');

        $commande2->setTotal('0'); 

        $manager->persist($commande2);
        $this->addReference('commande_1', $commande2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UtilisateurFixtures::class];
    }
}
