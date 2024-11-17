<?php

namespace App\Services;

use App\DTO\stock\CreateStockDTO;
use App\DTO\stock\UpdateStockDTO;
use App\Repositories\Stock\StockRepositoryInterface;
use stdClass;

class StockService
{
    public function __construct(
        protected StockRepositoryInterface $repositoryStock
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryStock->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryStock->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryStock->delete($id);
    }

    public function update(UpdateStockDTO $dto): stdClass|null
    {
        return $this->repositoryStock->update($dto);
    }
}