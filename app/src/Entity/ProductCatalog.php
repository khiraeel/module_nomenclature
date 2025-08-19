<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'product_catalog')]
#[ORM\HasLifecycleCallbacks]
class ProductCatalog
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private ?string $id;

    #[ORM\Column(type: Types::STRING)]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: ProductCategory::class)]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    private ?ProductCategory $category;

    #[ORM\ManyToOne(targetEntity: ProductSupplier::class)]
    #[ORM\JoinColumn(name: 'supplier_id', referencedColumnName: 'id', nullable: false)]
    private ?ProductSupplier $supplier;

    #[ORM\Column(type: Types::DECIMAL)]
    private ?string $price;

    #[ORM\Column(type: Types::STRING)]
    private ?string $file_url;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $is_active;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'created_by', referencedColumnName: 'id', nullable: false)]
    private ?User $created_by;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'updated_by', referencedColumnName: 'id', nullable: false)]
    private ?User $updated_by;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $updated_at;

    public function __construct(
        ?string $name,
        ?string $description,
        ?string $price,
        ?string $file_url,
        ?ProductCategory $category,
        ?ProductSupplier $supplier,
        ?User $user,
        ?\DateTimeImmutable $created_at,
    ) {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->file_url = $file_url;
        $this->category = $category;
        $this->supplier = $supplier;
        $this->created_by = $user;
        $this->updated_by = $user;
        $this->created_at = $created_at;
        $this->updated_at = $created_at;
        $this->is_active = true;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCategory(): ?ProductCategory
    {
        return $this->category;
    }

    public function setCategory(?ProductCategory $category): void
    {
        $this->category = $category;
    }

    public function getSupplier(): ?ProductSupplier
    {
        return $this->supplier;
    }

    public function setSupplier(?ProductSupplier $supplier): void
    {
        $this->supplier = $supplier;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    public function getFileUrl(): ?string
    {
        return $this->file_url;
    }

    public function setFileUrl(?string $file_url): void
    {
        $this->file_url = $file_url;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(?bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $updated_by): void
    {
        $this->updated_by = $updated_by;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }
}
