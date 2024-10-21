<?php

namespace App\Repositories\Cart;

use App\DTO\cart\{
    CreateCartDTO,
    UpdateCartDTO,
};

use stdClass;

interface CartRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $id): null|stdClass;
    public function delete(string $id): void;
    public function create(CreateCartDTO $dto): null|stdClass;
    // public function update(UpdateCartDTO $dto): null|stdClass;
}
