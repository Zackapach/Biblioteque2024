<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Suppose we have a few users and authors created before this
        $userRepository = $manager->getRepository(User::class);
        $authorRepository = $manager->getRepository(Author::class);

        $users = $userRepository->findAll();
        $authors = $authorRepository->findAll();

        // Check if there are users and authors
        if (empty($users) || empty($authors)) {
            throw new \Exception('Users and authors should be loaded before books.');
        }

        for ($i = 0; $i < 10; $i++) {
            $book = new Book();
            $book->setTitle('Book Title ' . $i);
            $book->setDescription('Description for book ' . $i);
            $book->setDatePublication(new \DateTime('-' . rand(1, 10) . ' years'));
            $book->setDateCreationBook(new \DateTime());
            $book->setDateModificationBook(new \DateTime());

            // Assign a random user
            $book->setUser($users[array_rand($users)]);

            // Assign random authors (could be multiple)
            $randomAuthors = array_rand($authors, rand(1, count($authors)));
            if (!is_array($randomAuthors)) {
                $randomAuthors = [$randomAuthors];
            }
            foreach ($randomAuthors as $authorIndex) {
                $book->addAuthor($authors[$authorIndex]);
            }

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class, // Ensure UserFixtures is loaded before BookFixtures
            AuthorFixtures::class, // Ensure AuthorFixtures is loaded before BookFixtures
        ];
    }
}
