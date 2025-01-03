<?php

namespace App\DTO\product;



class UpdateProductDTO
{
    public function __construct(
        public int $id,
        public string $description
    ) {
    }

    public static function makeFromRequest($request, string $id = null)
    {
        return new self(
            $id ?? $request->id,
            $request->description
        );
    }
}
