<?php

namespace App\DTO\product;

class CreateProductDTO
{
    public function __construct(
        public int $department_id,
        public string $ean,
        public string $description,
        public string $price,
        public string $quantity //TODO: Verificar melhor forma de tratar a quantidade
    ) {
    }

    public static function makeFromRequest($request): self
    {

        $self = new self(
            $request->department_id,
            $request->ean,
            $request->description,
            $request->price,
            $request->quantity
        );

        return $self;
    }
}
