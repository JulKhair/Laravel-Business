<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Payment;

class PaymentSeeder extends Seeder
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

        $payments = [
            [
                'order_id' => $renveraOrder->id,
                'payment_reference' => 'PAY-2026-001',
                'payment_method' => 'cash',
                'amount' => 1548.00,
                'paid_at' => '2026-10-27 09:15:00',
            ],
            [
                'order_id' => $salonirOrder->id,
                'payment_reference' => 'PAY-2026-002',
                'payment_method' => 'gcash',
                'amount' => 3999.00,
                'paid_at' => '2026-10-27 10:45:00',
            ],
        ];

        foreach ($payments as $payment) {
            Payment::firstOrCreate(
                [
                    'payment_reference' =>
                        $payment['payment_reference'],
                ],
                $payment
            );
        }
    }
}
