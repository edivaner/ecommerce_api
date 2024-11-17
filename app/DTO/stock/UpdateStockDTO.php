<?php

namespace App\DTO\stock;

class UpdateStockDTO
{
    public function __construct(
        public int $id,
        public int $product_id,
        public string $quantity //TODO: Verificar melhor forma de tratar a quantidade
    ) {}

    public static function makeFromRequest($request, string $id = null)
    {
        return new self(
            $id ?? $request->id,
            $request->product_id,
            $request->quantity
        );
    }
}
