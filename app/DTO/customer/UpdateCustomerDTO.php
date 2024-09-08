<?php

namespace App\DTO\customer;



class UpdateCustomerDTO
{
    public function __construct(
        public string $id,
        public array $user,
        public array $address,
        public string $telephone,
    ) {
    }

    public static function makeFromRequest($request, string $id = null)
    {
        return new self(
            $id ?? $request->id,
            $request->user,
            $request->address,
            $request->telephone
        );
    }
}
