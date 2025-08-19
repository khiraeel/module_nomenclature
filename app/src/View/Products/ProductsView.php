<?php

namespace App\View\Products;

use App\Entity\ProductCatalog;

readonly class ProductsView
{
    public function __construct(private ProductCatalog $product)
    {
    }

    public function getData(): array
    {
        return [
            'id' => $this->product->getId(),
            'name' => $this->product->getName(),
            'description' => $this->product->getDescription(),
            'price' => $this->product->getPrice(),
            'file_url' => $this->product->getFileUrl(),
            'category_id' => $this->product->getCategory()->getId(),
            'supplier_id' => $this->product->getSupplier()->getId(),
            'created_by' => $this->product->getCreatedBy()->getId(),
            'updated_by' => $this->product->getUpdatedBy()->getId(),
            'created_at' => $this->product->getCreatedAt(),
            'updated_at' => $this->product->getUpdatedAt(),
        ];
    }
}
