<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Renvera Kaslana',
                'email' => 'renvera.kaslana@example.com',
                'phone' => '09171234567',
                'address' => 'World Serpent Valley, Elysium',
            ],
            [
                'name' => 'Salonir Schariac',
                'email' => 'salonir.schariac@example.com',
                'phone' => '09181234567',
                'address' => 'Anti-Entropy Labs, Schicksal',
            ],
            [
                'name' => 'Xenva Apocalypse',
                'email' => 'xenva.apocalypse@example.com',
                'phone' => '09191234567',
                'address' => 'St. Freya Academy, Schicksal',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }
    }
}
