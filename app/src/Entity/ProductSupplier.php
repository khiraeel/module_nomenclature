<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
#[ORM\Table(name: '`product_supplier`')]
class ProductSupplier
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID)]
    private ?string $id;

    #[ORM\Column(type: Types::STRING)]
    private ?string $name;

    #[ORM\Column(type: Types::STRING)]
    private ?string $phone;

    #[ORM\Column(type: Types::STRING)]
    private ?string $contact_name;

    #[ORM\Column(type: Types::STRING)]
    private ?string $website;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    private ?string $description;

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
        ?string $phone,
        ?string $contact_name,
        ?string $website,
        ?User $created_by,
        ?\DateTimeImmutable $created_at,
    ) {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->phone = $phone;
        $this->contact_name = $contact_name;
        $this->website = $website;
        $this->description = $description;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getContactName(): ?string
    {
        return $this->contact_name;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setContactName(?string $contact_name): void
    {
        $this->contact_name = $contact_name;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setUpdatedBy(?User $updated_by): void
    {
        $this->updated_by = $updated_by;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
