<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\isUserOrder;
use App\Models\Order\Order;
use App\Models\Order\OrderStatus;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IsUserOrderTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrderFor(User $user): Order
    {
        $status = OrderStatus::firstOrCreate(
            ['slug' => 'pending'],
            ['name' => 'Pending', 'is_default' => true],
        );

        return Order::create([
            'user_id'     => $user->id,
            'status_id'   => $status->id,
            'total_price' => 10,
        ]);
    }

    public function test_owner_passes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $order = $this->makeOrderFor($user);

        $request = Request::create('/x');
        $request->order_id = $order->id;

        $response = (new isUserOrder())->handle($request, fn () => new Response('ok'));

        $this->assertSame('ok', $response->getContent());
    }

    public function test_foreigner_is_redirected(): void
    {
        $owner  = User::factory()->create();
        $other  = User::factory()->create();
        $order  = $this->makeOrderFor($owner);

        $this->actingAs($other);

        $request = Request::create('/x');
        $request->order_id = $order->id;

        $response = (new isUserOrder())->handle($request, fn () => new Response('ok'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
