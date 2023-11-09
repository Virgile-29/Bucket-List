<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\API\WishApiController;
use App\Entity\EntityListener\WishListener;
use App\Repository\WishRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WishRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['author', 'title'], message: 'On ne peut pas faire 2 fois le même voeux sinon ca marche pas XDPTDR')]
#[ORM\EntityListeners([WishListener::class])]
#[ApiResource(
    operations: [
        new GetCollection(
            controller: WishApiController::class,
            normalizationContext: ['groups' => 'wish:list']
        )
    ]
)]
class Wish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['wish:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['wish:list'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['wish:list'])]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    #[Groups(['wish:list'])]
    private ?string $author = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['wish:list'])]
    private ?bool $isPublished = true;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateCreated = null;

    #[ORM\ManyToOne(inversedBy: 'wishes')]
    #[Groups(['wish:list'])]
    private ?Category $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['wish:list'])]
    private ?string $image = null;

    public function __construct()
    {
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    #[ORM\PrePersist]
    public function setIsPublished(): static
    {
        $this->isPublished = true;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    #[ORM\PrePersist]
    public function setDateCreated(): static
    {
        $this->dateCreated = new \DateTime();

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
