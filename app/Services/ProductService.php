<?php

namespace App\Services;

use App\DTO\product\CreateProductDTO;
use App\DTO\product\UpdateProductDTO;
use App\Repositories\Product\ProductRepositoryInterface;
use stdClass;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repositoryProduct
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryProduct->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryProduct->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryProduct->delete($id);
    }

    public function create(CreateProductDTO $dto): stdClass|null
    {
        $product = $this->repositoryProduct->create($dto);
        if (!$product) return null;

        return $product;
    }

    public function update(UpdateProductDTO $dto): stdClass|null
    {
        return $this->repositoryProduct->update($dto);
    }
}