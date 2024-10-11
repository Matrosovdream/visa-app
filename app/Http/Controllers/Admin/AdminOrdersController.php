<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Helpers\adminSettingsHelper;

class AdminOrdersController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Orders',
            'orders' => Order::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.orders.index', $data);
    }

    public function show($id)
    {
        $order = Order::find($id);

        $data = [
            'title' => 'Order',
            'order' => $order,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.orders.show', $data);
    }

    public function edit($id)
    {
        $order = Order::find($id);

        $data = [
            'title' => 'Edit Order',
            'order' => $order,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.orders.edit', $data);
    }

}
