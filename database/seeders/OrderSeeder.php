<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::where(
            'email',
            'staff@example.com'
        )->firstOrFail();

        $renvera = Customer::where(
            'email',
            'renvera.kaslana@example.com'
        )->firstOrFail();

        $salonir = Customer::where(
            'email',
            'salonir.schariac@example.com'
        )->firstOrFail();

        $xenva = Customer::where(
            'email',
            'xenva.apocalypse@example.com'
        )->firstOrFail();

        $orders = [
            [
                'order_number' => 'ORD-2026-001',
                'customer_id' => $renvera->id,
                'user_id' => $staff->id,
                'order_date' => '2026-10-27 09:00:00',
                'status' => 'completed',
                'total_amount' => 1548.00,
            ],
            [
                'order_number' => 'ORD-2026-002',
                'customer_id' => $salonir->id,
                'user_id' => $staff->id,
                'order_date' => '2026-10-27 10:30:00',
                'status' => 'pending',
                'total_amount' => 3999.00,
            ],
            [
                'order_number' => 'ORD-2026-003',
                'customer_id' => $xenva->id,
                'user_id' => $staff->id,
                'order_date' => '2026-10-27 13:00:00',
                'status' => 'completed',
                'total_amount' => 5000.00,
            ],
        ];

        foreach ($orders as $order) {
            Order::firstOrCreate(
                ['order_number' => $order['order_number']],
                $order
            );
        }
    }
}
