<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Product;

class OrderSeeder extends Seeder
{

    public function run(): void
    {
        
        $orders = [
            [
                'user_id' => 1,
                'status_id' => 1,
                'payment_method_id' => 1,
                'products' => [1]
            ],
            [
                'user_id' => 2,
                'status_id' => 1,
                'payment_method_id' => 1,
                'products' => [2]
            ],
            [
                'user_id' => 1,
                'status_id' => 2,
                'payment_method_id' => 1,
                'products' => [3]
            ],
        ];

        foreach ($orders as $order) {

            $orderData = [
                'user_id' => $order['user_id'],
                'status_id' => $order['status_id'],
                'payment_method_id' => $order['payment_method_id']
            ];
            $order_id = Order::create($orderData);

            // Order products
            $orderProducts = [];
            foreach( $order['products'] as $product_id ) {

                $product = Product::find($product_id);

                $orderProducts[] = [
                    'order_id' => $order_id->id,
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'total' => $product->price,
                ];

            }

            foreach ($orderProducts as $orderProduct) {
                OrderProducts::create($orderProduct);
            }

        }

        // Order products
        /*
        foreach( $product_ids as $product_id ) {

            $product = Product::find($product_id);

            $orderProducts[] = [
                'order_id' => 1,
                'product_id' => $product_id,
                'quantity' => 1,
                'price' => $product->price,
                'total' => $product->price,
            ];

        }

        foreach ($orderProducts as $orderProduct) {
            OrderProducts::create($orderProduct);
        }

        // Sync order products by random
        $order = Order::find(1);
        $order->products()->sync([1, 2]);

        $order = Order::find(2);
        $order->products()->sync([2, 3]);

        $order = Order::find(3);
        $order->products()->sync([1, 2, 3]);
        */

    }

}
