<?php

namespace App\Repositories\Cart;

use App\DTO\cart\CreateCartDTO;
use App\DTO\cart\UpdateCartDTO;
use App\Models\Cart;
use App\Models\ItemCart;
use App\Repositories\Cart\CartRepositoryInterface;
use stdClass;

class CartEloquentORM implements CartRepositoryInterface
{

    public function __construct( 
        protected Cart $cart,
        protected ItemCart $itemCart)
    {}

    public function getAll(string $filter = null): array
    {
        return [];
    }   

    public function findOne(string $id):null|stdClass
    {
        return null;
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    public function create(CreateCartDTO $dto): null|stdClass
    {
        $cart = $this->cart->create([
            'customer_id' => $dto->customerId
        ]);

        foreach ($dto->products as $product) {
            $this->itemCart->create([
                'cart_id' => $cart->id,
                'product' => $product['product_id'],
                'quantity' => $product['quantity']
            ]);
        }

        return (object) $cart->toArray();
    }   

    // public function update(UpdateCartDTO $dto): null|stdClass
    // {
    //     return null;
    // }

}       