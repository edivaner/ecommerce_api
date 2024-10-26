<?php

namespace App\DTO\product;

use Ramsey\Uuid\Type\Decimal;

class CreateProductDTO
{
    public function __construct(
        public string $description,
        public string $ean,
        public string $price
    ) {
    }

    public static function makeFromRequest($request): self
    {

        $self = new self(
            $request->description,
            $request->ean,
            $request->price
        );

        return $self;
    }
}
