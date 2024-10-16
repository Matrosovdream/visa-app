<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
            ['name' => 'Universal eVisa 60 days', 'price' => 100, 'description' => 'Description Product 1', 'published' => 1],
            ['name' => 'Universal eVisa 90 days', 'price' => 200, 'description' => 'Description Product 2', 'published' => 1],
            ['name' => 'Universal eVisa 365 days', 'price' => 300, 'description' => 'Description Product 3', 'published' => 1],
        ];

        // Product meta data
        $meta[] = [
            ['key' => 'valid_for', 'value' => '60'],
            ['key' => 'entries_number', 'value' => '1'],
            ['key' => 'max_stay', 'value' => '60'],
        ];
        $meta[] = [
            ['key' => 'valid_for', 'value' => '90'],
            ['key' => 'entries_number', 'value' => '1'],
            ['key' => 'max_stay', 'value' => '90'],
        ];
        $meta[] = [
            ['key' => 'valid_for', 'value' => '365'],
            ['key' => 'entries_number', 'value' => '1'],
            ['key' => 'max_stay', 'value' => '365'],
        ];

        foreach ($products as $product) {

            // Create the product
            $product = Product::updateOrCreate(['slug' => Str::slug($product['name'])], $product);

            // Add meta data to the product
            foreach ($meta[$product->id - 1] as $item) {
                $product->meta()->create($item);
            }

            // Sync all countries to the product
            $product->countries()->sync(Country::all());

        }

    }
}
