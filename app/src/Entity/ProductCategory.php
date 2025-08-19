<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: '`product_category`')]
class ProductCategory
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private ?string $id;

    #[ORM\Column(type: Types::STRING)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?ProductCategory $parentCategory;

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
        ?ProductCategory $parentCategory,
        ?User $created_by,
        ?\DateTimeImmutable $created_at,
        ?\DateTimeImmutable $updated_at,
    ) {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->parentCategory = $parentCategory;
        $this->created_by = $created_by;
        $this->updated_by = $created_by;
        $this->created_at = $created_at;
        $this->updated_at = $created_at;
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

    public function getParent(): ?ProductCategory
    {
        return $this->parentCategory;
    }

    public function setParent(?ProductCategory $parentCategory): void
    {
        $this->parentCategory = $parentCategory;
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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
