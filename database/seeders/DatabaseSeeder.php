<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            
            // Users
            RoleSeeder::class,
            UserSeeder::class,

            // Referecences
            CountrySeeder::class,
            TravelDirectionSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,

            // Store products
            ProductSeeder::class,
            ProductOffersSeeder::class,
            ProductExtrasSeeder::class,

            // Store orders
            //OrderSeeder::class,
            GatewaySeeder::class,
            OrderStatusSeeder::class,

            // Content
            ArticleSeeder::class,

            // Settings
            SiteSettingsSeeder::class,
            
        ]);

    }
}
