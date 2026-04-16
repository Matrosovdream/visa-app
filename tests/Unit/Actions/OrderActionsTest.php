<?php

namespace Tests\Unit\Actions;

use App\Actions\Web\OrderActions;
use App\Models\Order\OrderStatus;
use App\Models\Payment\PaymentGateway;
use App\Models\Product\Product;
use App\Models\Product\ProductOffers;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Unit tests for the OrderActions pipeline — the critical path for
 * creating an order via the public "apply now" form.
 *
 * Currency is kept as USD throughout so CurrencyConverterService
 * short-circuits and does not reach the external API.
 */
class OrderActionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Required fixtures: user role, order status, payment gateway (ids are hard-coded to 1).
        Role::create(['title' => 'User', 'slug' => 'user', 'is_default' => true]);
        OrderStatus::create(['name' => 'Pending', 'slug' => 'pending', 'is_default' => true]);
        PaymentGateway::create(['name' => 'Stripe', 'slug' => 'stripe', 'is_active' => true]);
    }

    private function makeProductWithOffer(float $offerPrice = 100.0): array
    {
        $product = Product::create([
            'name'  => 'Tourist Visa',
            'slug'  => 'tourist-visa',
            'price' => $offerPrice,
        ]);

        $offer = ProductOffers::create([
            'product_id' => $product->id,
            'name'       => 'Standard',
            'price'      => $offerPrice,
        ]);

        return [$product, $offer];
    }

    private function applyRequest(array $overrides = []): Request
    {
        return new Request(array_merge([
            'product_id'        => 1,
            'offer_id'          => 1,
            'quantity'          => 1,
            'currency'          => 'USD',
            'country_to_id'     => 14,
            'country_to_code'   => 'AU',
            'country_from_id'   => 11,
            'country_from_code' => 'AR',
            'time_arrival'      => '2026-10-29',
            'full_name'         => 'John Doe',
            'phone'             => '+1234567890',
            'email'             => 'john@example.com',
            'travelers' => [
                'name'                      => ['John'],
                'lastname'                  => ['Doe'],
                'birthday'                  => ['1995-01-01'],
                'passport'                  => ['AB123456'],
                'passport-expiration-day'   => ['25'],
                'passport-expiration-month' => ['5'],
                'passport-expiration-year'  => ['2030'],
            ],
        ], $overrides));
    }

    public function test_create_order_creates_user_when_guest(): void
    {
        $this->makeProductWithOffer(100.0);

        $order = OrderActions::createOrder($this->applyRequest());

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertNotNull($order->user_id);
        $this->assertSame('john@example.com', $order->user->email);
    }

    public function test_create_order_uses_authed_user_when_available(): void
    {
        $user = User::factory()->create(['email' => 'existing@example.com']);
        auth()->login($user);

        $this->makeProductWithOffer(100.0);

        $order = OrderActions::createOrder($this->applyRequest());

        $this->assertSame($user->id, $order->user_id);
    }

    public function test_create_order_persists_order_with_computed_total(): void
    {
        $this->makeProductWithOffer(150.0);

        $order = OrderActions::createOrder($this->applyRequest(['quantity' => 2]));

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
        // Product has no extras → total = offer price * quantity = 300.
        $this->assertEquals(300, (int) str_replace(',', '', $order->getTotal()));
    }

    public function test_create_order_generates_random_hash(): void
    {
        $this->makeProductWithOffer();

        $order = OrderActions::createOrder($this->applyRequest());

        $this->assertNotEmpty($order->hash);
        $this->assertEquals(32, strlen($order->hash));
    }

    public function test_create_order_writes_meta_for_trip_fields(): void
    {
        $this->makeProductWithOffer();

        $order = OrderActions::createOrder($this->applyRequest());

        foreach (['country_to_id', 'country_to_code', 'country_from_id',
                  'country_from_code', 'currency', 'time_arrival',
                  'full_name', 'phone', 'email'] as $key) {
            $this->assertDatabaseHas('order_meta', [
                'order_id' => $order->id,
                'key'      => $key,
            ]);
        }
    }

    public function test_create_order_attaches_travellers_and_their_meta(): void
    {
        $this->makeProductWithOffer();

        $order = OrderActions::createOrder($this->applyRequest([
            'travelers' => [
                'name'                      => ['John', 'Jane'],
                'lastname'                  => ['Doe', 'Doe'],
                'birthday'                  => ['1995-01-01', '1990-01-01'],
                'passport'                  => ['AB123456', 'CD987654'],
                'passport-expiration-day'   => ['25', '13'],
                'passport-expiration-month' => ['5', '12'],
                'passport-expiration-year'  => ['2030', '2029'],
            ],
        ]));

        $this->assertCount(2, $order->travellers);
        $this->assertSame('John Doe', $order->travellers[0]->full_name);
        $this->assertSame('Jane Doe', $order->travellers[1]->full_name);
    }

    public function test_create_order_writes_cart_and_cart_product(): void
    {
        $this->makeProductWithOffer(80.0);

        $order = OrderActions::createOrder($this->applyRequest(['quantity' => 3]));

        // Cart's `status` column is not mass-assignable, so it takes the DB default.
        $this->assertDatabaseHas('carts', [
            'order_id' => $order->id,
            'currency' => 'USD',
        ]);
        $this->assertDatabaseHas('cart_products', [
            'order_id'   => $order->id,
            'product_id' => 1,
            'offer_id'   => 1,
            'quantity'   => 3,
        ]);
    }

    public function test_create_order_writes_history_entry(): void
    {
        $this->makeProductWithOffer();

        $order = OrderActions::createOrder($this->applyRequest());

        $this->assertDatabaseHas('order_history', [
            'order_id' => $order->id,
            'action'   => 'create',
        ]);
    }

    public function test_create_user_sets_user_role(): void
    {
        $request = new Request([
            'email'     => 'fresh@example.com',
            'full_name' => 'Fresh Applicant',
        ]);

        $user = OrderActions::createUser($request);

        $this->assertTrue($user->hasRole(['user']));
    }

    public function test_create_user_is_idempotent_on_email(): void
    {
        User::factory()->create(['email' => 'already@example.com']);

        $request = new Request([
            'email'     => 'already@example.com',
            'full_name' => 'Duplicate Attempt',
        ]);

        $before = User::count();
        OrderActions::createUser($request);
        $after = User::count();

        $this->assertSame($before, $after);
    }
}
