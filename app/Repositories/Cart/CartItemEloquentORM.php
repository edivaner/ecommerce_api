<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\ItemCart;
use App\Repositories\Cart\CartRepositoryInterface;
use stdClass;

class CartItemEloquentORM implements CartItemRepositoryInterface
{

    public function __construct( 
        protected Cart $cart,
        protected ItemCart $itemCart)
    {}

    public function getAll(string $filter = null): array
    {
        return $this->cart
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('id', $filter);
                }
            })
            ->get()
            ->toArray();
    }   

    public function findOne(string $idCart, string $idProduct):null|stdClass
    {
        $cartItem = $this->itemCart->where('cart_id', $idCart)->where('product', $idProduct)->first();
        if (!$cartItem) return null;
        return (object) $cartItem->toArray();
    }

    public function delete(string $idCart, string $idProduct): void
    {
        $this->itemCart->where('cart_id', $idCart)->where('product', $idProduct)->delete();
    }

    public function create($dto): null|stdClass
    {
        return null;
    }   

    public function update($dto): null|stdClass
    {
        return null;
    }

    public function updateQuantity(string $idCart, string $idProduct, int $quantity): null|stdClass
    {
        $this->itemCart->where('cart_id', $idCart)->where('product', $idProduct)->update(['quantity' => $quantity]);
        return $this->findOne($idCart, $idProduct);
    }

    public function updateAddItem(string $idCart, string $idProduct, int $quantity): null|stdClass
    {
        $this->itemCart->create(['cart_id' => $idCart, 'product' => $idProduct, 'quantity' => $quantity]);

        return $this->findOne($idCart, $idProduct);
    }
}       