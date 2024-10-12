<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $gateways = [
            [
                'name' => 'Authorize.Net',
                'slug' => 'authnet',
                'description' => 'Authorize.Net payment gateway',
                'image' => 'paypal.png',
                'is_active' => true
            ]
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::create($gateway);
        }


    }
}
