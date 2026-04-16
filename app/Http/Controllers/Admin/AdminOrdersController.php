<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepo;
use App\Repositories\Order\OrderStatusRepo;
use App\Helpers\adminSettingsHelper;

class AdminOrdersController extends Controller
{
    public function __construct(
        private OrderRepo $orderRepo,
        private OrderStatusRepo $orderStatusRepo
    ) {}

    public function index()
    {
        $orders = $this->orderRepo->getAll([], 10);
        $statuses = $this->orderStatusRepo->getAll([], 100);

        $data = [
            'title' => 'Orders',
            'orders' => $orders['Model'],
            'orderStatuses' => $statuses['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];
        return view('admin.orders.index', $data);
    }

    public function show($id)
    {
        $order = $this->orderRepo->getByID($id);
        $statuses = $this->orderStatusRepo->getAll([], 100);

        $data = [
            'title' => 'Order',
            'order' => $order['Model'],
            'orderStatuses' => $statuses['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.orders.show', $data);
    }

    public function edit($id)
    {
        $order = $this->orderRepo->getByID($id);

        $data = [
            'title' => 'Edit Order',
            'order' => $order['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.orders.edit', $data);
    }
}
