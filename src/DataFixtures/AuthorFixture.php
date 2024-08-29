<?php 

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $author = new Author();
            $author->setName('Author Name ' . $i);
            $author->setFirstName('Author FirstName ' . $i);
            $author->setDateOfBirth(new \DateTime('-' . rand(30, 60) . ' years'));
            $author->setDateCreationAuthor(new \DateTime());
            $author->setDateModificationAuthor(new \DateTime());

            $manager->persist($author);
        }

        $manager->flush();
    }
}