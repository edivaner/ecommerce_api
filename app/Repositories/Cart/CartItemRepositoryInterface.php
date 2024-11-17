<?php

namespace App\Repositories\Cart;


use stdClass;

interface CartItemRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $idCart, string $idProduct): null|stdClass;
    public function delete(string $idCart, string $idProduct): void;
    public function create($dto): null|stdClass;
    public function update($dto): null|stdClass;
    public function updateQuantity(string $idCart, string $idProduct, int $quantity): null|stdClass;
    public function updateAddItem(string $idCart, string $idProduct, int $quantity): null|stdClass;
}
