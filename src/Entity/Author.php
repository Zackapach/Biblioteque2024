<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreationAuthor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModificationAuthor = null;

    #[ORM\ManyToOne(inversedBy: 'authors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    /**
     * @var Collection<int, book>
     */
    #[ORM\ManyToMany(targetEntity: book::class, inversedBy: 'authors')]
    private Collection $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
        $this->date_creation = new \DateTime(); // Initialize date_creation
        $this->date_modification = new \DateTime()
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getDateCreationAuthor(): ?\DateTimeInterface
    {
        return $this->dateCreationAuthor;
    }

    public function setDateCreationAuthor(\DateTimeInterface $dateCreationAuthor): static
    {
        $this->dateCreationAuthor = $dateCreationAuthor;

        return $this;
    }

    public function getDateModificationAuthor(): ?\DateTimeInterface
    {
        return $this->dateModificationAuthor;
    }

    public function setDateModificationAuthor(?\DateTimeInterface $dateModificationAuthor): static
    {
        $this->dateModificationAuthor = $dateModificationAuthor;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, book>
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(book $book): static
    {
        if (!$this->book->contains($book)) {
            $this->book->add($book);
        }

        return $this;
    }

    public function removeBook(book $book): static
    {
        $this->book->removeElement($book);

        return $this;
    }
}
