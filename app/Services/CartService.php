<?php

namespace App\Services;

use App\DTO\cart\CreateCartDTO;
use App\DTO\cart\UpdateCartDTO;
use App\Repositories\Cart\CartRepositoryInterface;
use stdClass;

class CartService
{
    public function __construct(
        protected CartRepositoryInterface $repositoryCart
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryCart->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryCart->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryCart->delete($id);
    }

    public function create(CreateCartDTO $dto): stdClass|null
    {
        $cart = $this->repositoryCart->create($dto);
        if (!$cart) return null;

        return $cart;
    }

    // public function update(UpdateCartDTO $dto): stdClass|null
    // {
    //     return $this->repositoryCart->update($dto);
    // }
}