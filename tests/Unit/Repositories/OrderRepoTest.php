<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Order\OrderRepo;
use App\Models\Order\Order;
use App\Models\Order\OrderStatus;
use App\Models\User\User;

class OrderRepoTest extends TestCase
{
    use RefreshDatabase;

    private OrderRepo $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new OrderRepo();
    }

    private function createUserAndStatus(): array
    {
        $user = User::create([
            'name' => 'Order User',
            'email' => 'order@test.com',
            'password' => bcrypt('password'),
        ]);

        $status = OrderStatus::create([
            'name' => 'Pending',
            'slug' => 'pending',
            'color' => '#000',
            'is_default' => true,
        ]);

        return [$user, $status];
    }

    public function test_create_order(): void
    {
        [$user, $status] = $this->createUserAndStatus();

        $result = $this->repo->create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 100,
            'payment_method_id' => 1,
        ]);

        $this->assertNotNull($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('hash', $result);
        $this->assertArrayHasKey('Model', $result);
    }

    public function test_get_by_hash(): void
    {
        [$user, $status] = $this->createUserAndStatus();

        $order = Order::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 200,
            'payment_method_id' => 1,
        ]);

        $result = $this->repo->getByHash($order->hash);

        $this->assertNotNull($result);
        $this->assertEquals($order->id, $result['id']);
    }

    public function test_get_by_user(): void
    {
        [$user, $status] = $this->createUserAndStatus();

        Order::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 100,
            'payment_method_id' => 1,
        ]);

        Order::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 200,
            'payment_method_id' => 1,
        ]);

        $result = $this->repo->getByUser($user->id, 10);

        $this->assertArrayHasKey('items', $result);
        $this->assertGreaterThanOrEqual(2, $result['items']->count());
    }

    public function test_check_user_access(): void
    {
        [$user, $status] = $this->createUserAndStatus();

        $order = Order::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 100,
            'payment_method_id' => 1,
        ]);

        $this->assertTrue($this->repo->checkUserAccess($user->id, $order->id));
        $this->assertFalse($this->repo->checkUserAccess(99999, $order->id));
    }

    public function test_delete_order(): void
    {
        [$user, $status] = $this->createUserAndStatus();

        $order = Order::create([
            'user_id' => $user->id,
            'status_id' => $status->id,
            'total_price' => 100,
            'payment_method_id' => 1,
        ]);

        $deleted = $this->repo->delete($order->id);
        $this->assertTrue($deleted);
    }
}
