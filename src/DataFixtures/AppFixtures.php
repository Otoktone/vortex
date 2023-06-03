<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Feed;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        // create user
        $user = new User();
        $username = 'visiteur';
        $plaintextPassword = 'visiteur';
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setUsername($username);
        $user->setEmail('visiteur@vortex.fr');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        // create feed
        $feed = new Feed();
        $feed->setName('Korben')->setUrl('https://korben.info/feed');


        $manager->persist($user);
        $manager->persist($feed);
        $manager->flush();
    }
}
