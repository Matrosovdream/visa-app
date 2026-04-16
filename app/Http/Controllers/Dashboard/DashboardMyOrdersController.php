<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepo;
use App\Helpers\adminSettingsHelper;

class DashboardMyOrdersController extends Controller
{
    public function __construct(private OrderRepo $orderRepo) {}

    public function index()
    {
        $result = $this->orderRepo->getByUser(auth()->user()->id, 10);

        $data = [
            'title' => 'My Orders',
            'orders' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.my_orders.index', $data);
    }

    public function show($order_id)
    {
        $order = $this->orderRepo->getByID($order_id);

        $data = [
            'title' => 'Order details',
            'order' => $order['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.my_orders.show', $data);
    }
}
