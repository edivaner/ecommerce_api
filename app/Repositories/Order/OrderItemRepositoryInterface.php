<?php

namespace App\Repositories\Order;


use stdClass;

interface OrderItemRepositoryInterface
{
    public function getAll(string $filter = null): array;
    public function findOne(string $idOrder, string $idProduct = null): null|stdClass;
    public function delete(string $idOrder, string $idProduct): void;
    public function create($dto): null|stdClass;
    public function update($dto): null|stdClass;
    public function updateQuantity(string $idOrder, string $idProduct, int $quantity): null|stdClass;
    public function updateAddItem(string $idOrder, string $idProduct, int $quantity): null|stdClass;
}
