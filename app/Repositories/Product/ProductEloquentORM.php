<?php

namespace App\Repositories\Product;

use App\DTO\product\CreateProductDTO;
use App\DTO\product\UpdateProductDTO;
use App\Models\Product;
use App\Models\Stock;
use App\Repositories\Product\ProductRepositoryInterface;
use stdClass;

class ProductEloquentORM implements ProductRepositoryInterface
{
    public function __construct(
        protected Product $product,
        protected Stock $stock
    ) {
    }

    public function getAll(string $filter = null): array
    {
        $product = $this->product
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->get()
            ->toArray();

        foreach ($product as $key => $value) {
            $stock = $this->stock->where('product_id', $value['id'])->first();
            $product[$key]['stock'] = $stock->toArray();
        }

        return $product;
    }

    public function findOne(string $id): stdClass
    {
        $product = $this->product->with(['stock'])->find($id)->toArray();

        if (!$product) return null;

        $stock = $this->stock->where('product_id', $id)->first();
        $product['stock'] = $stock->toArray();
    
        return (object) $product;
    }

    public function delete(string $id): void
    {
        //
    }

    public function create(CreateProductDTO $dto): stdClass
    {
        $product = $this->product->create([
            'description'   => $dto->description,
            'ean'           => $dto->ean,
            'department_id' => $dto->department_id,
            'price'         => $dto->price
        ]);

        $stock = $this->stock->create([
            'quantity'   => $dto->quantity,
            'product_id' => $product->id
        ]);

        return (object) $product->toArray();
    }

    public function update(UpdateProductDTO $dto): stdClass
    {
        //
    }
}
