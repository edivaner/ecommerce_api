<?php

namespace App\DTO\department;

class CreateDepartmentDTO
{
    public function __construct(
        public string $name
    ) {}

    public static function makeFromRequest($request): self
    {

        $self = new self(
            $request->name
        );

        return $self;
    }
}
