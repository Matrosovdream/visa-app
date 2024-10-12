<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Add a few products and sync all countries to them
        $products = [
            ['name' => 'Product 1', 'price' => 100, 'description' => 'Description Product 1', 'published' => 1],
            ['name' => 'Product 2', 'price' => 200, 'description' => 'Description Product 2', 'published' => 1],
            ['name' => 'Product 3', 'price' => 300, 'description' => 'Description Product 3', 'published' => 1],
        ];

        foreach ($products as $product) {
            $product = Product::create($product);
            $product->countries()->sync(Country::all());
        }

    }
}
