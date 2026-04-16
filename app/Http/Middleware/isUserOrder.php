<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Order\Order;

class isUserOrder
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Order::checkUserAccess(Auth::user()->id, $request->order_id)) {
            return redirect()->route('web.account.orders');
        }

        return $next($request);
    }
}
