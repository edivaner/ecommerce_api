<?php

namespace App\DTO\department;



class UpdateDepartmentDTO
{
    public function __construct(
        public int $id,
        public string $name
    ) {}

    public static function makeFromRequest($request, string $id = null)
    {
        return new self(
            $id ?? $request->id,
            $request->name
        );
    }
}
