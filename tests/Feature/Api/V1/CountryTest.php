<?php

namespace Tests\Feature\Api\V1;

use App\Models\Geo\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_countries(): void
    {
        Country::create(['name' => 'United States', 'code' => 'US', 'slug' => 'united-states']);
        Country::create(['name' => 'Canada', 'code' => 'CA', 'slug' => 'canada']);

        $response = $this->getJson('/api/v1/countries');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_can_show_country_by_slug(): void
    {
        Country::create(['name' => 'United States', 'code' => 'US', 'slug' => 'united-states']);

        $response = $this->getJson('/api/v1/countries/united-states');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_show_country_returns_404_for_missing_slug(): void
    {
        $response = $this->getJson('/api/v1/countries/nonexistent');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Country not found.']);
    }

    public function test_can_get_country_products(): void
    {
        Country::create(['name' => 'United States', 'code' => 'US', 'slug' => 'united-states']);

        $response = $this->getJson('/api/v1/countries/united-states/products');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_country_products_returns_404_for_missing_country(): void
    {
        $response = $this->getJson('/api/v1/countries/nonexistent/products');

        $response->assertStatus(404);
    }
}
