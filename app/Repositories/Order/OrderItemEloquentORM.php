<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Order\OrderRepositoryInterface;
use stdClass;

class OrderItemEloquentORM implements OrderItemRepositoryInterface
{

    public function __construct( 
        protected Order $cart,
        protected OrderItem $orderItem,)
    {}

    public function getAll(string $filter = null): array
    {
        return $this->orderItem
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->get()
            ->toArray();
    }   

    public function findOne(string $idOrder, string $idProduct = null):null|stdClass
    {
        if($idProduct){
            $orderItem = $this->orderItem->where('order_id', $idOrder)->where('product', $idProduct)->first();
        }else{
            $orderItem = $this->orderItem->where('order_id', $idOrder)->first();
        }
        
        if (!$orderItem) return null;
        return (object) $orderItem->toArray();
    }

    public function delete(string $idOrder, string $idProduct): void
    {
        $this->orderItem->where('order_id', $idOrder)->where('product', $idProduct)->delete();
    }

    public function create($dto): null|stdClass
    {
        return null;
    }   

    public function update($dto): null|stdClass
    {
        return null;
    }

    public function updateQuantity(string $idOrder, string $idProduct, int $quantity): null|stdClass
    {
        $this->orderItem->where('order_id', $idOrder)->where('product', $idProduct)->update(['quantity' => $quantity]);
        return $this->findOne($idOrder, $idProduct);
    }

    public function updateAddItem(string $idOrder, string $idProduct, int $quantity): null|stdClass
    {
        $this->orderItem->create(['order_id' => $idOrder, 'product' => $idProduct, 'quantity' => $quantity]);

        return $this->findOne($idOrder, $idProduct);
    }
}       