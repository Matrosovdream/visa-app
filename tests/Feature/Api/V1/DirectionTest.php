<?php

namespace Tests\Feature\Api\V1;

use App\Models\Geo\Country;
use App\Models\Geo\TravelDirection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DirectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_direction(): void
    {
        $from = Country::create(['name' => 'United States', 'code' => 'US', 'slug' => 'united-states']);
        $to = Country::create(['name' => 'Canada', 'code' => 'CA', 'slug' => 'canada']);

        TravelDirection::create([
            'name' => 'US to Canada',
            'slug' => 'us-to-canada',
            'country_from_id' => $from->id,
            'country_to_id' => $to->id,
            'country_from_code' => 'US',
            'country_to_code' => 'CA',
        ]);

        $response = $this->getJson('/api/v1/directions/search?from=US&to=CA');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_search_direction_returns_404_when_not_found(): void
    {
        $response = $this->getJson('/api/v1/directions/search?from=XX&to=YY');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Direction not found.']);
    }

    public function test_search_direction_requires_from_and_to(): void
    {
        $response = $this->getJson('/api/v1/directions/search');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['from', 'to']);
    }

    public function test_search_direction_requires_from(): void
    {
        $response = $this->getJson('/api/v1/directions/search?to=CA');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['from']);
    }

    public function test_search_direction_requires_to(): void
    {
        $response = $this->getJson('/api/v1/directions/search?from=US');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['to']);
    }
}
