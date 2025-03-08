<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read'])]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['product:read'])]
    #[Assert\NotBlank(message: "Short description cannot be empty.")]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: "Description must be at least {{ limit }} characters long.",
        maxMessage: "Description cannot exceed {{ limit }} characters."
    )]
    private ?string $shortDescription;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Price is required.")]
    #[Assert\Positive(message: "Price must be a positive number.")]
    #[Groups(['product:read'])]
    private float $priceExclVat;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Choice(choices: ["Books", "Home", "Electronics", "Clothing"], message: "Invalid category.")]
    #[Groups(['product:read'])]
    private string $category;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $image = null;

    #[ORM\Column(type: "boolean")]
    #[Groups(['product:read'])]
    private bool $isTop = false;

    #[ORM\Column(type: "boolean")]
    #[Groups(['product:read'])]
    private bool $isFeatured = false;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['product:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['product:read'])]
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getPriceExclVat(): ?float
    {
        return $this->priceExclVat;
    }

    public function setPriceExclVat(float $priceExclVat): static
    {
        $this->priceExclVat = $priceExclVat;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
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

    public function isTop(): bool
    {
        return $this->isTop;
    }

    public function setIsTop(bool $isTop): self
    {
        $this->isTop = $isTop;
        return $this;
    }

    public function isFeatured(): bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(bool $isFeatured): self
    {
        $this->isFeatured = $isFeatured;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(?\DateTime $createdAt): static
    {
        if ($this->createdAt === null) { // Ensure it's only set if null
            $this->createdAt = new \DateTime();
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
