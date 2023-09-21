<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface; 
use App\Entity\User;
use App\Entity\Events;


class UserFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $password = $this->passwordHasher->hashPassword($user, 'password123');
            $user->setPassword($password);

            $manager->persist($user);
        }

        for ($i = 0; $i < 6; $i++) {
            $evenement = new Events();
            $evenement->setTitre($faker->sentence(3));
            $evenement->setDescription($faker->paragraph(3));
            $evenement->setDateDebut($faker->dateTimeBetween('+1 week', '+6 months'));
            $evenement->setDateFin($faker->dateTimeBetween('+1 week', '+6 months'));
            $evenement->setLieu($faker->sentence(3));
            $evenement->setUser($user);

            $manager->persist($evenement);
        }

        $manager->flush();
    }
}