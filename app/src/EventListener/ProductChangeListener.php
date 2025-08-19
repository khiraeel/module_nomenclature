<?php

namespace App\EventListener;

use App\Entity\ProductCatalog;
use App\Entity\ChangeLogs;
use App\Repository\ChangeLogsRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'onProductCreated', entity: ProductCatalog::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'onProductUpdate', entity: ProductCatalog::class)]
#[AsEntityListener(event: Events::postRemove, method: 'onProductRemove', entity: ProductCatalog::class)]
final class ProductChangeListener
{
    public function __construct(
        private ProductRepository $productRepository,
        private ChangeLogsRepository $changeLogsRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function onProductCreated(ProductCatalog $productCatalog, PostUpdateEventArgs $event): void
    {
        dd($productCatalog);
        $changeLogs = new ChangeLogs(

        );
    }

    public function onProductUpdate(ProductCatalog $productCatalog, PostUpdateEventArgs $event): void
    {
    }

    public function onProductRemove(ProductCatalog $productCatalog, PostUpdateEventArgs $event): void
    {
    }
}
