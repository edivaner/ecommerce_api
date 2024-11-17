<?php

namespace App\Services;

use App\Repositories\Cart\CartItemRepositoryInterface;
use stdClass;

class CartItemService
{
    public function __construct(
        protected CartItemRepositoryInterface $repositoryCartItem
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryCartItem->getAll($filter);
    }
    public function findOne(string $idCart, string $idProduct): stdClass|null
    {
        return $this->repositoryCartItem->findOne($idCart, $idProduct);
    }

    public function delete(string $idCart, string $idProduct): void
    {
        $this->repositoryCartItem->delete($idCart, $idProduct);
    }

    public function create($dto): stdClass|null
    {
        $cart = $this->repositoryCartItem->create($dto);
        if (!$cart) return null;

        return $cart;
    }

    public function update($dto): stdClass|null
    {
        return $this->repositoryCartItem->update($dto);
    }

    public function updateQuantity(string $idCart, string $idProduct, int $quantity): stdClass|null
    {
        return $this->repositoryCartItem->updateQuantity($idCart, $idProduct, $quantity);
    }

    public function updateAddItem(string $idCart, string $idProduct, int $quantity): stdClass|null
    {
        return $this->repositoryCartItem->updateAddItem($idCart, $idProduct, $quantity);
    }
}