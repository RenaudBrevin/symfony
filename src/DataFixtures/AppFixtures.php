<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setName('Admin');
        $admin->setFirstname('Super');
        $admin->setPoints(10000);
        $admin->setActif(true);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@user.com');
        $user->setName('User');
        $user->setFirstname('Normal');
        $user->setPoints(1500);
        $user->setActif(true);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        $categories = ['Électronique', 'Vêtements', 'Alimentation', 'Autre'];
        
        for ($i = 1; $i <= 10; $i++) {
            $produit = new Product();
            $produit->setName('Produit ' . $i);
            $produit->setPrice(random_int(50, 300));
            $produit->setCategory($categories[array_rand($categories)]);
            $produit->setDescription('Description' . $i);
            $produit->setCreateBy($admin);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}