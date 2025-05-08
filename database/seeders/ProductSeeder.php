<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products =[
            [
                'name' => 'Product 1',
                'description' => 'Description for Product 1',
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for Product 2',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
