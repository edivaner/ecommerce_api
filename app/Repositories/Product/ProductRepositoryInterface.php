<?php

namespace App\Repositories\Product;

use App\DTO\product\{
    CreateProductDTO,
    UpdateProductDTO,
};

use stdClass;

interface ProductRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function create(CreateProductDTO $dto): null|stdClass;
    public function update(UpdateProductDTO $dto): null|stdClass;
}
