<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UtilisateurFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Admin pas obliger mais pratique pour les tests et l'admin
        $admin = new Utilisateur();
        $admin->setEmail('admin@test.com');
        $admin->setNom($faker->lastName());
        $admin->setPrenom($faker->firstName());
        $admin->setDateInscription(new \DateTime());
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $manager->persist($admin);

        $this->addReference('user_admin', $admin);

        // Users: user_0 ... user_9
        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setEmail($faker->unique()->email());
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setDateInscription(new \DateTime());
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));

            $manager->persist($user);
            $this->addReference('user_'.$i, $user);
        }

        $manager->flush();
    }
}
