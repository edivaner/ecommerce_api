<?php

namespace App\Repositories\Order;

use App\Models\Cart;
use App\Models\ItemCart;
use App\Models\Order;
use App\Models\OrderItem;
use stdClass;

class OrderEloquentORM implements OrderRepositoryInterface
{

    public function __construct( 
        protected Cart $cart,
        protected ItemCart $itemCart,
        protected Order $order,
        protected OrderItem $orderItem
        )
    {}

    public function getAll(string $filter = null): array
    {
        return $this->order
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->get()
            ->toArray();
    }   

    public function findOne(string $id):null|stdClass
    {
        $order = $this->order->find($id);
        $order->items = $this->orderItem->where('order_id', $id)->get()->toArray();
        if (!$order) return null;
        return (object) $order->toArray();
    }

    public function delete(string $id): void
    {
        $this->order->findOrFail($id)->delete();
    }

    public function create($order): null|stdClass
    {
        $orderReturn = $this->order->create([
            'customer_id' => $order->customer_id,
            'cart_id' => $order->cart_id,
            'status' => $order->status
        ]);

        foreach ($order->products as $product) {
            $this->orderItem->create([
                'order_id' => $orderReturn->id,
                'product' => $product['product'],
                'quantity' => $product['quantity'],
                'price' => 0
            ]);
        }

        return (object) $orderReturn->toArray();
    }   

    public function update($id, $dto): null|stdClass
    {
        $orderReturn = $this->order->where('id', $id)->first();
        if (!$orderReturn) return null;

        foreach ($dto as $key => $value) {
            $orderReturn->update([$key => $value]);
        }

        return (object) $orderReturn->toArray();
    }

    public function updateStatus(string $id, string $status): null|stdClass
    {
        $this->order->where('id', $id)->update(['status' => $status]);
        return $this->findOne($id);
    }

}       