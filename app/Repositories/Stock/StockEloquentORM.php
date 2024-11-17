<?php

namespace App\Repositories\Stock;

use App\DTO\stock\UpdateStockDTO;
use App\Models\Stock;
use App\Repositories\Stock\StockRepositoryInterface;
use stdClass;

class StockEloquentORM implements StockRepositoryInterface
{
    public function __construct(
        protected Stock $stock
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->stock
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->get()
            ->toArray();
    }

    public function findOne(string $id): stdClass
    {
        $stock = $this->stock->find($id);
        if (!$stock) return null;
        return (object) $stock->toArray();
    }

    public function delete(string $id): void
    {
        //
    }

    public function update(UpdateStockDTO $dto): stdClass
    {
        if (!$stock = $this->stock->find($dto->id)) {
            return null;
        }

        $stock->update(['quantity' => $dto->quantity]);

        return (object) $stock->toArray();
    }
}
