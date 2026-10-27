<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->firstOrFail();
        $clothing = Category::where('name', 'Clothing')->firstOrFail();
        $homeLiving = Category::where('name', 'Home & Living')->firstOrFail();

        $products = [
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Mouse',
                'description' => 'Wireless computer mouse',
                'price' => 599.00,
                'stock_quantity' => 25,
                'is_available' => true,
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Mechanical Keyboard',
                'description' => 'Mechanical keyboard for computers',
                'price' => 2499.00,
                'stock_quantity' => 12,
                'is_available' => true,
            ],
            [
                'category_id' => $clothing->id,
                'name' => 'Basic T-Shirt',
                'description' => 'Comfortable cotton shirt',
                'price' => 350.00,
                'stock_quantity' => 40,
                'is_available' => true,
            ],
            [
                'category_id' => $clothing->id,
                'name' => 'Denim Jacket',
                'description' => 'Classic denim jacket',
                'price' => 1800.00,
                'stock_quantity' => 10,
                'is_available' => true,
            ],
            [
                'category_id' => $homeLiving->id,
                'name' => 'Desk Lamp',
                'description' => 'LED lamp for desks',
                'price' => 750.00,
                'stock_quantity' => 18,
                'is_available' => true,
            ],
            [
                'category_id' => $homeLiving->id,
                'name' => 'Office Chair',
                'description' => 'Ergonomic chair for office use',
                'price' => 3200.00,
                'stock_quantity' => 8,
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                [
                    'category_id' => $product['category_id'],
                    'name' => $product['name'],
                ],
                $product
            );
        }
    }
}
