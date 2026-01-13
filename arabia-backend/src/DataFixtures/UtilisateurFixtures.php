<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // ADMIN
        $admin = new Utilisateur();
        $admin->setEmail('admin@test.com');
        $admin->setNom('Admin');
        $admin->setPrenom('Root');
        $admin->setDateInscription(new \DateTime());
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'password')
        );
        $manager->persist($admin);

        // références nécessaires pour CommandeFixtures
        $this->addReference('user_admin', $admin);

        // USER
        $user = new Utilisateur();
        $user->setEmail('user@test.com');
        $user->setNom('User');
        $user->setPrenom('Client');
        $user->setDateInscription(new \DateTime());
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'password')
        );
        $manager->persist($user);

        // référence nécessaire pour CommandeFixtures
        $this->addReference('user_user', $user);

        $manager->flush();
    }
}
