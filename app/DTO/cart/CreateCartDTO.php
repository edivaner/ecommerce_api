<?php

namespace App\DTO\cart;


class CreateCartDTO
{
    public function __construct(
        public int $customerId,
        public array $products
    ) {
    }

    public static function makeFromRequest($request): self
    {
        $self = new self(
            $request->customerId,
            $request->products
        );

        return $self;
    }
}
