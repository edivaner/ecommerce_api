<?php

namespace App\Policies;

use App\Models\User;

class CartBelongsUserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user, $cart)
    {
        $customer_id = $cart->customer_id;
        $userCart = User::find($customer_id);

        if($userCart->id == $user->id)
            return true;
        else    
            return false;
    }
}
