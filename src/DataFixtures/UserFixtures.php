<?php 

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@example.com');
            $user->setPassword('password'); // In a real app, you'd hash this
            $user->setRoles(['ROLE_USER']);
            $user->setDateCreation(new \DateTime());
            $user->setDateModification(new \DateTime());

            $manager->persist($user);
        }

        $manager->flush();
    }
}