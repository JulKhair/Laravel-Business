<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $renveraOrder = Order::where(
            'order_number',
            'ORD-2026-001'
        )->firstOrFail();

        $salonirOrder = Order::where(
            'order_number',
            'ORD-2026-002'
        )->firstOrFail();

        $xenvaOrder = Order::where(
            'order_number',
            'ORD-2026-003'
        )->firstOrFail();

        $mouse = Product::where(
            'name',
            'Wireless Mouse'
        )->firstOrFail();

        $keyboard = Product::where(
            'name',
            'Mechanical Keyboard'
        )->firstOrFail();

        $shirt = Product::where(
            'name',
            'Basic T-Shirt'
        )->firstOrFail();

        $lamp = Product::where(
            'name',
            'Desk Lamp'
        )->firstOrFail();

        $jacket = Product::where(
            'name',
            'Denim Jacket'
        )->firstOrFail();

        $chair = Product::where(
            'name',
            'Office Chair'
        )->firstOrFail();

        $items = [
            [
                'order_id' => $renveraOrder->id,
                'product_id' => $mouse->id,
                'quantity' => 2,
                'unit_price' => 599.00,
                'subtotal' => 1198.00,
            ],
            [
                'order_id' => $renveraOrder->id,
                'product_id' => $shirt->id,
                'quantity' => 1,
                'unit_price' => 350.00,
                'subtotal' => 350.00,
            ],
            [
                'order_id' => $salonirOrder->id,
                'product_id' => $keyboard->id,
                'quantity' => 1,
                'unit_price' => 2499.00,
                'subtotal' => 2499.00,
            ],
            [
                'order_id' => $salonirOrder->id,
                'product_id' => $lamp->id,
                'quantity' => 2,
                'unit_price' => 750.00,
                'subtotal' => 1500.00,
            ],
            [
                'order_id' => $xenvaOrder->id,
                'product_id' => $jacket->id,
                'quantity' => 1,
                'unit_price' => 1800.00,
                'subtotal' => 1800.00,
            ],
            [
                'order_id' => $xenvaOrder->id,
                'product_id' => $chair->id,
                'quantity' => 1,
                'unit_price' => 3200.00,
                'subtotal' => 3200.00,
            ],
        ];

        foreach ($items as $item) {
            OrderItem::firstOrCreate(
                [
                    'order_id' => $item['order_id'],
                    'product_id' => $item['product_id'],
                ],
                $item
            );
        }
    }
}
