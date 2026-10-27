<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['name' => 'Electronics'],
            ['description' => 'Electronic devices and accessories']
        );

        Category::firstOrCreate(
            ['name' => 'Clothing'],
            ['description' => 'Apparel and fashion items']
        );

        Category::firstOrCreate(
            ['name' => 'Home & Living'],
            ['description' => 'Furniture and household essentials']
        );
    }
}