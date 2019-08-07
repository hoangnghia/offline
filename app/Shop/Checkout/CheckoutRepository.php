<?php

namespace App\Shop\Checkout;

use App\Events\OrderCreateEvent;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;

class CheckoutRepository
{
    /**
     * @param array $data
     *
     * @return Order
     */
    public function buildCheckoutItems(array $data) : Order
    {
        $orderRepo = new OrderRepository(new Order);

        $order = $orderRepo->createOrder([
            'reference' => $data['reference'],
            'courier_id' => 1,
            'customer_id' => $data['customer_id'],
//            'address_id' =>1,
            'order_status_id' => $data['order_status_id'],
            'payment' => $data['payment'],
            'discounts' => 0,
            'total_products' => (int) $data['total_products'],
            'total' => (int) $data['total'],
            'total_paid' => 0,
            'total_shipping' => isset($data['total_shipping']) ? $data['total_shipping'] : 0,
            'tax' => 0
        ]);

        return $order;
    }
}
