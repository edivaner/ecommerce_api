<?php

namespace App\Services;

use App\Repositories\Order\OrderRepositoryInterface;
use stdClass;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $repositoryOrder,
        protected CartService $cartService
    ) {}

    public function getAll(string $filter = null): array
    {
        return $this->repositoryOrder->getAll($filter);
    }
    public function findOne(string $id): stdClass|null
    {
        return $this->repositoryOrder->findOne($id);
    }

    public function delete(string $id): void
    {
        $this->repositoryOrder->delete($id);
    }

    public function create($order): stdClass|null
    {
        $cart = $this->cartService->findOne($order->cart_id);
        if (!$cart) throw new \Exception('Carrinho não encontrado');

        $order->customer_id = $cart->customer_id;
        $order->status = 'pending';
        $order->products = $cart->items;

        $orderReturn = $this->repositoryOrder->create($order);
        if (!$orderReturn) return null;

        return $orderReturn;
    }

    public function update(string $id, $order): stdClass|null
    {
        return $this->repositoryOrder->update($id, $order);
    }

    public function updateStatus(string $id, string $status): void
    {
        $this->repositoryOrder->updateStatus($id, $status);
    }
}