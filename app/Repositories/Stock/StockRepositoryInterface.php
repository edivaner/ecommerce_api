<?php

namespace App\Repositories\Stock;

use App\DTO\stock\{
    UpdateStockDTO,
};

use stdClass;

interface StockRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function update(UpdateStockDTO $dto): null|stdClass;
}
