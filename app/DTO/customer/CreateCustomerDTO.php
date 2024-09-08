<?php

namespace App\DTO\customer;


class CreateCustomerDTO
{
    public function __construct(
        public array $user,
        public array $address,
        public string $telephone,
    ) {
    }

    public static function makeFromRequest($request): self
    {
        // dd($request);

        $self = new self(
            $request->user,
            $request->address,
            $request->telephone
        );

        return $self;
    }
}
