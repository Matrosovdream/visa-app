<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductOffersSeeder extends Seeder
{
    public function run(): void
    {

        // Basic offers list
        $offers = [
            [
                'name' => 'Standard', 
                'price' => 30, 
                'description' => 'Standard offer for 2 days',
                'metas' => [
                    ['key' => 'duration', 'value' => '2 days'],
                    ['key' => 'duration_hours', 'value' => 72],
                ],
            ],
            [
                'name' => 'Rush', 
                'price' => 75, 
                'description' => 'Rush offer for 5 hours',
                'metas' => [
                    ['key' => 'duration', 'value' => '5 hours'],
                    ['key' => 'duration_hours', 'value' => 5],
                ],
            ],
            [
                'name' => 'Super Rush', 
                'price' => 200, 
                'description' => 'Rush offer for 2 hours',
                'metas' => [
                    ['key' => 'duration', 'value' => '2 hours'],
                    ['key' => 'duration_hours', 'value' => 2],
                ],
            ],
            
        ];
        
        // Take all products
        $products = Product::all();

        // Loop through all products
        foreach ($products as $product) {

            // Assign metas to the offers
            foreach ($offers as $offer) {
                $product->offers()->create([
                    'name' => $offer['name'],
                    'price' => $offer['price'],
                    'description' => $offer['description'],
                ])->meta()->createMany($offer['metas']);
            }

        }

    }
}
