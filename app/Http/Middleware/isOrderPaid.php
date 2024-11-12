<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;

class isOrderPaid
{

    public function handle(Request $request, Closure $next): Response
    {
        $order = Order::findOrFail($request->order_id);

        if ( !$order->isPaid() ) {
            return redirect()->route('web.account.orders');
        }

        return $next($request);
    }
}
