<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_publication = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\OneToMany(targetEntity: user::class, mappedBy: 'book')]
    private Collection $user;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation_book = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_modification_book = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $User = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'book')]
    private Collection $authors;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->date_creation = new \DateTime(); // Initialize date_creation
        $this->date_modification = new \DateTime()
    }
 public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->date_modification;
    }

    public function setDateModification(?\DateTimeInterface $date_modification): static
    {
        $this->date_modification = $date_modification;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): static
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(user $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setBook($this);
        }

        return $this;
    }

    public function removeUser(user $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getBook() === $this) {
                $user->setBook(null);
            }
        }

        return $this;
    }

    public function getDateCreationBook(): ?\DateTimeInterface
    {
        return $this->date_creation_book;
    }

    public function setDateCreationBook(\DateTimeInterface $date_creation_book): static
    {
        $this->date_creation_book = $date_creation_book;

        return $this;
    }

    public function getDateModificationBook(): ?\DateTimeInterface
    {
        return $this->date_modification_book;
    }

    public function setDateModificationBook(?\DateTimeInterface $date_modification_book): static
    {
        $this->date_modification_book = $date_modification_book;

        return $this;
    }

    public function setUser(?user $User): static
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }
}
