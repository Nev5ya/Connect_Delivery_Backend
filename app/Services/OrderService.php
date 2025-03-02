<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;

class OrderService
{
    /**
     * @param Order $order
     * @param array $state
     * @return Order
     */
    public function changeOrderAndUserState(Order $order, array $state): Order
    {
        $user = User::query()->find($state['user_id'] ?? $order->getAttribute('user_id'));

        /**
         * Assign user to order
         * Set { order_status_id } to state { transit }
         * Set { user_status_id } to state { busy }
         */
        if(isset($state['user_id'])) {

            $order->setAttribute('user_id', $state['user_id']);

            $order->setAttribute('order_status_id', 2);

            $user->setAttribute('user_status_id', 3);

        }

        /**
         * Button "delivered"
         * Set { order_status_id } to state { delivered }
         * Set { user_status_id } to state { online }
         */
        if (isset($state['order_status_id'])) {

            $order->setAttribute('order_status_id', $state['order_status_id']);

            $user->setAttribute('user_status_id', 2);

        }

        $user->save();

        return $order;
    }
}
