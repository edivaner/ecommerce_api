<?php

namespace App\Policies;

use App\Models\User;

class OrderBelongsUserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user, $order)
    {
        $customer_id = $order->customer_id;
        $userOrder = User::find($customer_id);

        if($userOrder->id == $user->id)
            return true;
        else    
            return false;
    }
}
