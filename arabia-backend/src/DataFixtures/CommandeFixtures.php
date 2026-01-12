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
        for ($i = 0; $i < 10; $i++) {
            $commande = new Commande();
            $commande->setDateCommande(new \DateTime());
            $commande->setStatut('en cours');
            $commande->setTotal('0.00');

            $userIndex = random_int(0, 9);

            $commande->setUtilisateur(
                $this->getReference('user_'.$userIndex, Utilisateur::class)
            );

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
