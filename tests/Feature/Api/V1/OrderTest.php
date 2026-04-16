<?php

namespace Tests\Feature\Api\V1;

use App\Models\Order\Order;
use App\Models\Order\OrderStatus;
use App\Models\Traveller\Traveller;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder(User $user): Order
    {
        $status = OrderStatus::create([
            'name' => 'Pending',
            'slug' => 'pending',
            'is_default' => true,
        ]);

        return Order::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 100.00,
        ]);
    }

    private function createTraveller(Order $order): Traveller
    {
        $traveller = Traveller::create([
            'full_name' => 'John Doe',
            'name' => 'John',
            'lastname' => 'Doe',
            'birthday' => '1990-01-01',
            'passport' => 'AB123456',
        ]);

        $order->travellers()->attach($traveller->id);

        return $traveller;
    }

    // --- Order list ---

    public function test_authenticated_user_can_list_orders(): void
    {
        $user = User::factory()->create();
        $this->createOrder($user);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/orders');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_unauthenticated_user_cannot_list_orders(): void
    {
        $response = $this->getJson('/api/v1/orders');

        $response->assertStatus(401);
    }

    // --- Order show ---

    public function test_authenticated_user_can_show_order(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}");

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_show_order_returns_404_for_missing_order(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/orders/99999');

        $response->assertStatus(404);
    }

    // --- Order preview (public) ---

    public function test_can_preview_order_by_hash(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);

        $response = $this->getJson("/api/v1/orders/preview/{$order->hash}");

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_preview_returns_404_for_invalid_hash(): void
    {
        $response = $this->getJson('/api/v1/orders/preview/invalidhash123');

        $response->assertStatus(404);
    }

    // --- Trip details ---

    public function test_authenticated_user_can_get_trip_details(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/trip");

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_authenticated_user_can_update_trip_details(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/orders/{$order->id}/trip", [
                'meta' => ['travel_date' => '2025-01-01'],
            ]);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    // --- Order documents ---

    public function test_authenticated_user_can_get_order_documents(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/documents");

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    // --- Applicant sections ---

    public function test_can_get_applicant_documents(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/documents");

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_can_get_applicant_personal(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/personal");

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_can_update_applicant_personal(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/personal", [
                'fields' => ['first_name' => 'Jane'],
            ]);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_can_get_applicant_passport(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/passport");

        $response->assertOk();
    }

    public function test_can_update_applicant_passport(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/passport", [
                'fields' => ['passport_number' => 'XY987654'],
            ]);

        $response->assertOk();
    }

    public function test_can_get_applicant_family(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/family");

        $response->assertOk();
    }

    public function test_can_update_applicant_family(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/family", [
                'fields' => ['marital_status' => 'single'],
            ]);

        $response->assertOk();
    }

    public function test_can_get_applicant_past_travel(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/past-travel");

        $response->assertOk();
    }

    public function test_can_update_applicant_past_travel(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/past-travel", [
                'fields' => ['visited_countries' => 'UK, France'],
            ]);

        $response->assertOk();
    }

    public function test_can_get_applicant_declarations(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/declarations");

        $response->assertOk();
    }

    public function test_can_update_applicant_declarations(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/declarations", [
                'fields' => ['criminal_record' => 'no'],
            ]);

        $response->assertOk();
    }

    public function test_can_update_applicant_fields(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/fields", [
                'fields' => ['some_field' => 'some_value'],
            ]);

        $response->assertOk();
    }

    public function test_can_delete_applicant_document(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrder($user);
        $traveller = $this->createTraveller($order);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/v1/orders/{$order->id}/applicants/{$traveller->id}/documents/1");

        $response->assertOk()
            ->assertJson(['message' => 'Document deleted.']);
    }

    // --- Auth guard on order endpoints ---

    public function test_unauthenticated_user_cannot_get_trip_details(): void
    {
        $response = $this->getJson('/api/v1/orders/1/trip');

        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_get_documents(): void
    {
        $response = $this->getJson('/api/v1/orders/1/documents');

        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_access_applicant_section(): void
    {
        $response = $this->getJson('/api/v1/orders/1/applicants/1/personal');

        $response->assertStatus(401);
    }
}
