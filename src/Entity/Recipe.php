<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use App\Validator\BanWord;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'Ce titre est déjà utilisé.')]
#[UniqueEntity(fields: ['slug'], message: 'Ce slug est déjà utilisé.')]
class Recipe
{
    #[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type: Types::INTEGER)]
private ?int $id = null;

#[ORM\Column(type: Types::STRING, length: 255)]
#[Assert\Length(
    min: 3,
    max: 255,
    minMessage: 'Le titre doit comporter au moins {{ limit }} caractères.',
    maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.'
)]
#[Assert\Regex(
    pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{1,16}$/',
)]
private ?string $title = null;

#[ORM\Column(type: Types::STRING, length: 255)]
#[Assert\Length(
    min: 3,
    max: 255,
    minMessage: 'Le slug doit comporter au moins {{ limit }} caractères.',
    maxMessage: 'Le slug ne peut pas dépasser {{ limit }} caractères.'
)]
#[Assert\Regex(
    pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{1,16}$/',
)]

private ?string $slug = null;

#[ORM\Column(type: Types::TEXT)]
private ?string $content = null;

#[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
private ?\DateTimeImmutable $created_at = null;

#[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
private ?\DateTimeImmutable $updated_at = null;

#[ORM\Column]
#[Assert\Positive]
#[Assert\NotBlank]
private ?int $duration = null;

#[ORM\ManyToOne(inversedBy: 'recipes', cascade: ['persist'])]
private ?Category $category = null;


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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

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
}
