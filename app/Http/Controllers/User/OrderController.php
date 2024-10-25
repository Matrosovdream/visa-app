<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\Country;
use App\Helpers\userSettingsHelper;
use App\Models\ProductOffers;
use App\Services\CurrencyConverterService;


class OrderController extends Controller
{

    public function show($hash)
    {

        $order = Order::getByHash($hash);

        $data = array(
            'title' => 'Homepage',
            'menuTop' => userSettingsHelper::getTopMenu(),
            'countries' => Country::all(),
            'order' => $order
        );

        return view('web.order.show', $data);
    }
    
    public function createApply(Request $request)
    {

        $currency = request('currency');

        // Calculate product price
        $product = Product::find(request('product_id'));
        $offer = ProductOffers::find(request('offer_id'));
        $price = $offer->price + $product->extras->sum('price');
        $price = CurrencyConverterService::convert('USD', $currency, $price);

        // Calculate total price
        $totalPrice = $price * request('quantity');

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status_id' => 1,
            'payment_method_id' => 1,
            'total_price' => $totalPrice,
        ]);

        // Add order meta fields
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
            'travelers'
        ];
        foreach ($fields as $field) {
            $value = request($field);
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

        // Create a cart
        $cart = Cart::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'session_id' => session()->getId(),
            'status' => 'active',
            'currency' => $currency,
        ]);

        // Add products to the cart
        CartProduct::create([
            'cart_id' => $cart->id,
            'order_id' => $order->id,
            'product_id' => request('product_id'),
            'offer_id' => request('offer_id'),
            'quantity' => request('quantity'),
            'price' => $price,
            'total' => $price * request('quantity'),
        ]);

        // Add history
        $order->history()->create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'comment' => 'Order created',
        ]);

        // Redirect to the order page
        return redirect()->route('web.order.show', $order->hash);

    }

    public function pay($hash)
    {
        $order = Order::getByHash($hash);

        // Payment processing
        

        // Change order status
        $order->status_id = 2;
        $order->save();

        // Redirect to the order page
        return redirect()->route('web.order.show', $order->hash);
    }

}
