<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\Geo\Country;
use App\Models\Order\OrderStatus;
use App\Models\Payment\PaymentGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminReferenceTest extends AdminTestCase
{
    use RefreshDatabase;

    public function test_roles_endpoint_returns_all_roles(): void
    {
        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/roles');

        $response->assertOk()->assertJsonStructure(['data' => [['id', 'title', 'slug']]]);
        $slugs = collect($response->json('data'))->pluck('slug')->all();
        $this->assertContains('admin', $slugs);
        $this->assertContains('user', $slugs);
    }

    public function test_order_statuses_endpoint(): void
    {
        OrderStatus::create(['name' => 'Pending', 'slug' => 'pending', 'is_default' => true]);
        OrderStatus::create(['name' => 'Paid', 'slug' => 'paid']);

        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/order-statuses');

        $response->assertOk();
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_countries_endpoint(): void
    {
        Country::create(['name' => 'Testland', 'slug' => 'testland', 'code' => 'TL']);

        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/countries');

        $response->assertOk()->assertJsonStructure(['data' => [['id', 'name', 'code', 'slug']]]);
    }

    public function test_gateways_endpoint(): void
    {
        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/gateways');

        $response->assertOk()->assertJsonStructure(['data']);
    }

    public function test_directions_endpoint(): void
    {
        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/directions');

        $response->assertOk()->assertJsonStructure(['data']);
    }
}
