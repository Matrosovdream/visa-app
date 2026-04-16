<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\Order\Order;
use App\Models\Order\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminOrdersTest extends AdminTestCase
{
    use RefreshDatabase;

    private function pendingStatus(): OrderStatus
    {
        return OrderStatus::firstOrCreate(
            ['slug' => 'pending'],
            ['name' => 'Pending', 'is_default' => true]
        );
    }

    public function test_admin_can_list_orders(): void
    {
        $admin = $this->admin();
        Order::create([
            'user_id'     => $admin->id,
            'status_id'   => $this->pendingStatus()->id,
            'total_price' => 100,
        ]);

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/orders');

        $response->assertOk()->assertJsonStructure(['data']);
    }

    public function test_admin_can_create_order(): void
    {
        $admin = $this->admin();
        $status = $this->pendingStatus();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/orders', [
            'user_id'     => $admin->id,
            'status_id'   => $status->id,
            'total_price' => 199.99,
        ]);

        // Order model rounds total_price via a number_format accessor.
        $response->assertStatus(201)->assertJsonPath('data.total_price', '200');
    }

    public function test_store_validates_total_price(): void
    {
        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/orders', [
            'total_price' => -5,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['total_price']);
    }

    public function test_admin_can_show_order(): void
    {
        $admin = $this->admin();
        $order = Order::create([
            'user_id' => $admin->id, 'status_id' => $this->pendingStatus()->id, 'total_price' => 100,
        ]);

        $response = $this->actingAs($admin)->getJson("/api/v1/admin/orders/{$order->id}");

        $response->assertOk()->assertJsonPath('data.id', $order->id);
    }

    public function test_admin_can_update_order_status(): void
    {
        $admin = $this->admin();
        $order = Order::create([
            'user_id' => $admin->id, 'status_id' => $this->pendingStatus()->id, 'total_price' => 100,
        ]);
        $newStatus = OrderStatus::create(['name' => 'Paid', 'slug' => 'paid']);

        $response = $this->actingAs($admin)->putJson("/api/v1/admin/orders/{$order->id}", [
            'status_id' => $newStatus->id,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id, 'status_id' => $newStatus->id,
        ]);
    }

    public function test_admin_can_delete_order(): void
    {
        $admin = $this->admin();
        $order = Order::create([
            'user_id' => $admin->id, 'status_id' => $this->pendingStatus()->id, 'total_price' => 100,
        ]);

        $response = $this->actingAs($admin)->deleteJson("/api/v1/admin/orders/{$order->id}");

        $response->assertOk()->assertJson(['message' => 'Order deleted.']);
    }
}
