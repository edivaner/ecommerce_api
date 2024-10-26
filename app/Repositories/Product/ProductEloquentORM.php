<?php

namespace App\Repositories\Product;

use App\DTO\product\CreateProductDTO;
use App\DTO\product\UpdateProductDTO;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use stdClass;

class ProductEloquentORM implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $product
    ) {
    }

    public function getAll(string $filter = null): array
    {
        return $this->product
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->with(['description'])
            ->get()
            ->toArray();
    }

    public function findOne(string $id): stdClass
    {
        $product = $this->product->with(['description'])->find($id);
        if (!$product) return null;
        return (object) $product->toArray();
    }

    public function delete(string $id): void
    {
        $product   = $this->product->findOrFail($id)->toArray();

        if ($product) {
            $this->product->findOrFail($id)->delete();
        }
    }

    public function create(CreateProductDTO $dto): stdClass
    {
        $product = $this->product->create([
            'description' => $dto->description,
            'ean'         => $dto->ean,
            'price'       => $dto->price
        ]);

        return (object) $product->toArray();
    }

    public function update(UpdateProductDTO $dto): stdClass
    {
        if (!$product = $this->product->find($dto->id)) {
            return null;
        }

        $product->update(['description' => $dto->description]);

        return (object) $product->toArray();
    }
}
