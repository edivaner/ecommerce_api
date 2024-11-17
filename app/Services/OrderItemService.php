<?php

namespace App\Services;

use App\Repositories\Order\OrderItemRepositoryInterface;
use stdClass;

class OrderItemService
{
    public function __construct(
        protected OrderItemRepositoryInterface $repositoryOrderItem
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryOrderItem->getAll($filter);
    }
    public function findOne(string $idOrder, string $idProduct = null): stdClass|null
    {
        return $this->repositoryOrderItem->findOne($idOrder, $idProduct);

    }

    public function delete(string $idOrder, string $idProduct): void
    {
        $this->repositoryOrderItem->delete($idOrder, $idProduct);
    }

    public function create($dto): stdClass|null
    {
        $order = $this->repositoryOrderItem->create($dto);
        if (!$order) return null;

        return $order;
    }

    public function update($dto): stdClass|null
    {
        return $this->repositoryOrderItem->update($dto);
    }

    public function updateQuantity(string $idOrder, string $idProduct, int $quantity): stdClass|null
    {
        return $this->repositoryOrderItem->updateQuantity($idOrder, $idProduct, $quantity);
    }

    public function updateAddItem(string $idOrder, string $idProduct, int $quantity): stdClass|null
    {
        return $this->repositoryOrderItem->updateAddItem($idOrder, $idProduct, $quantity);
    }
}