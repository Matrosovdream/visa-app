<?php
namespace App\Actions\Web;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\ProductOffers;
use App\Services\CurrencyConverterService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Traveller;
use App\Helpers\TravellerHelper;



class OrderActions {

    public static function createOrder( Request $request ) {

        // Create or find user by email
        $USER = self::createUser($request, $role = 'user');

        // Log in user
        auth()->login($USER);

        // Calculate product price
        $price = self::getProductPrice($request);

        // Calculate total price
        $totalPrice = $price * $request->quantity;

        // Create order
        $order = Order::create([
            'user_id' => $USER->id,
            'status_id' => 1,
            'payment_method_id' => 1,
            'total_price' => $totalPrice,
        ]);

        // Add order meta fields
        self::addOrderMeta($order, $request);

        // Add travellers
        self::addTravellers($order, $request);

        // Create a cart
        $cart = Cart::create([
            'user_id' => $USER->id,
            'order_id' => $order->id,
            'session_id' => session()->getId(),
            'status' => 'active',
            'currency' => $request->currency,
        ]);

        // Add products to the cart
        CartProduct::create([
            'cart_id' => $cart->id,
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'offer_id' => $request->offer_id,
            'quantity' => $request->quantity,
            'price' => $price,
            'total' => $price * $request->quantity,
        ]);

        // Add to history
        $order->history()->create([
            'user_id' => $USER->id,
            'action' => 'create',
            'comment' => 'Order created',
        ]);

        return $order;

    }

    public static function getProductPrice( $request ) {

        $product = Product::find($request->product_id);
        $offer = ProductOffers::find($request->offer_id);

        $price = $offer->price + $product->extras->sum('price');
        $price = CurrencyConverterService::convert('USD', $request->currency, $price);

        return $price;

    }

    public static function createUser( $request, $role = 'user' ) {

        $user = User::firstOrCreate([
            'email' => $request->email,
        ], [
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt(Str::random(16)),
        ]);

        // Set role
        $user->setRole('user');

        return $user;

    }

    public static function addOrderMeta( $order, $request ) {

        $fields = [
            'country_to_id', 
            'country_to_code', 
            'country_from_id', 
            'country_from_code',
            'currency',
            'time_arrival',
            'full_name',
            'phone',
            'email',
        ];
        foreach ($fields as $field) {
            $value = $request->$field;
            if( is_array($value) ) {
                $value = json_encode($value);
            }

            if ( $value ) {
                $order->meta()->create([
                    'key' => $field,
                    'value' => $value,
                ]);
            }
        }

    }

    public static function addTravellers( $order, $request ) {

        $travellers = TravellerHelper::preparePostTraveller( $request->travelers );
        foreach ($travellers as $traveller) {

            $travellerSet = $order->travellers()->create($traveller['traveller']);
            foreach( $traveller['meta'] as $metafield ) {
                $travellerSet->meta()->create($metafield);
            }

        }

    }

    public static function imitateOrderCreate() {

        $request = new Request([
            'product_id' => 1,
            'offer_id' => 1,
            'quantity' => 1,
            'currency' => 'USD',
            'country_to_id' => 14,
            'country_to_code' => 'AU',
            'country_from_id' => 11,
            'country_from_code' => 'AR',
            'time_arrival' => '2024-10-29',
            'full_name' => 'John Doe',
            'phone' => '+1234567890',
            'email' => '22@gmail.com', 
            'travelers' => [
                'name' => [
                    'John',
                    'Jane',
                ],
                'lastname' => [
                    'Doe',
                    'Doe',
                ],
                'birthday' => [
                    '1995-01-01',
                    '1990-01-01',
                ],
                'passport' => [
                    '123456111',
                    '123456555',
                ],
                'passport-expiration-day' => [
                    '25',
                    '13',
                ],
                'passport-expiration-month' => [
                    '5',
                    '12',
                ],
                'passport-expiration-year' => [
                    '2026',
                    '2029',
                ],
            ],
        ]);

        return self::createOrder($request);

    }

}