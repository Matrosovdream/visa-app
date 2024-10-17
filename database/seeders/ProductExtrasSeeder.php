<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductExtrasSeeder extends Seeder
{
    public function run(): void
    {

        // Basic offers list
        $extras = [
            [
                'name' => 'Government fees',
                'price' => 55,
                'description' => '',
                'type' => 'gov_fees',
                'metas' => [
                    //['key' => 'duration', 'value' => '2 days'],
                    //['key' => 'duration_hours', 'value' => 72],
                ],
            ],
        ];

        // Take all products
        $products = Product::all();

        // Loop through all products
        foreach ($products as $product) {

            // Assign metas to the offers
            foreach ($extras as $extra) {
                $product->extras()->create([
                    'name' => $extra['name'],
                    'price' => $extra['price'],
                    'description' => $extra['description'],
                    'type' => $extra['type'],
                ])->meta()->createMany($extra['metas']);
            }

        }


    }
}
