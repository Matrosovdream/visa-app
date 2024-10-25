<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Helpers\adminSettingsHelper;

class DashboardMyOrdersController extends Controller
{

    public function index()
    {

        $orders = Order::where('user_id', auth()->user()->id)->paginate(10);

        $data = [
            'title' => 'My Orders',
            'orders' => $orders,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.my_orders.index', $data);
    }

    public function show($order_id)
    {
        $order = Order::find($order_id);

        $data = [
            'title' => 'Order details',
            'order' => $order,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.my_orders.show', $data);
    }

}
