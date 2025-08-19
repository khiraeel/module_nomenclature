<?php

namespace App\View\Products;

readonly class ProductsViewList
{
    public function __construct(private array $product)
    {
    }

    public function getData(): array
    {
        $list = [];

        for ($i = 0; $i < count($this->product); ++$i) {
            $product = $this->product[$i];
            $list[$i] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'file_url' => $product->getFileUrl(),
                'category_id' => $product->getCategory()->getId(),
                'supplier_id' => $product->getSupplier()->getId(),
                'created_by' => $product->getCreatedBy()->getId(),
                'updated_by' => $product->getUpdatedBy()->getId(),
                'created_at' => $product->getCreatedAt(),
                'updated_at' => $product->getUpdatedAt(),
            ];
        }

        return $list;
    }
}
