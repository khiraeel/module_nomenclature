<?php

namespace App\Entity;

use App\Repository\ChangeLogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChangeLogsRepository::class)]
#[ORM\Table(name: '`change_logs`')]
class ChangeLogs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::GUID)]
    private ?string $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'id', nullable: false)]
    private ?User $user;

    #[ORM\Column(type: Types::STRING)]
    private ?string $entity_type;

    #[ORM\Column(type: Types::GUID)]
    private ?string $entity_id;

    #[ORM\Column(type: Types::STRING)]
    private ?string $action; // created, updated, deleted

    #[ORM\Column(type: Types::JSON)]
    private ?string $changes;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at;

    private const ENTITY_MAP = [
        'product' => ProductCatalog::class,
        'category' => ProductCategory::class,
        'supplier' => ProductSupplier::class,
    ];

    public function __construct(
        ?User $user,
        ?string $entity_type,
        ?string $entity_id,
        ?string $action,
        ?string $changes,
        ?\DateTimeImmutable $created_at,
    ) {
        $this->user = $user;
        $this->entity_type = $entity_type;
        $this->entity_id = $entity_id;
        $this->action = $action;
        $this->changes = $changes;
        $this->created_at = $created_at;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
