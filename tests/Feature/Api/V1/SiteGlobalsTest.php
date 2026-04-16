<?php

namespace Tests\Feature\Api\V1;

use App\Models\Geo\Language;
use App\Models\Geo\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteGlobalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_active_languages(): void
    {
        Language::create(['name' => 'English', 'code' => 'en', 'is_default' => true, 'is_active' => true]);
        Language::create(['name' => 'French', 'code' => 'fr', 'is_default' => false, 'is_active' => true]);
        Language::create(['name' => 'German', 'code' => 'de', 'is_default' => false, 'is_active' => false]);

        $response = $this->getJson('/api/v1/languages');

        $response->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJsonCount(2, 'data');
    }

    public function test_languages_returns_empty_when_none_active(): void
    {
        $response = $this->getJson('/api/v1/languages');

        $response->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_can_list_active_currencies(): void
    {
        Currency::create(['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'is_default' => true, 'is_active' => true]);
        Currency::create(['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'is_default' => false, 'is_active' => true]);
        Currency::create(['name' => 'British Pound', 'code' => 'GBP', 'symbol' => '£', 'is_default' => false, 'is_active' => false]);

        $response = $this->getJson('/api/v1/currencies');

        $response->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJsonCount(2, 'data');
    }

    public function test_currencies_returns_empty_when_none_active(): void
    {
        $response = $this->getJson('/api/v1/currencies');

        $response->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
