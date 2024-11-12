<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Helpers\adminSettingsHelper;
use App\Models\OrderStatus;
use App\Helpers\TravellerHelper;

class DashboardOrdersController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Orders',
            'orders' => Order::paginate(10),
            'orderStatuses' => OrderStatus::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];
        return view('dashboard.orders.index', $data);
    }

    public function show($id)
    {
        $order = Order::find($id);

        $data = [
            'title' => 'Order',
            'order' => $order,
            'orderStatuses' => OrderStatus::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.orders.show', $data);
    }

    public function edit($id)
    {
        $order = Order::find($id);

        $data = [
            'title' => 'Edit Order',
            'order' => $order,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.orders.edit', $data);
    }

    public function update($id)
    {
        $order = Order::find($id);

        $order->status = request('status');
        $order->save();

        return redirect()->route('dashboard.orders.index');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route('dashboard.orders.index');
    }

    public function travellersCreate($id)
    {

    }

    public function travellersStore($id)
    {
        $order = Order::find($id);

        $order->travellers()->create([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'passport' => request('passport'),
            'country' => request('country'),
            'direction' => request('direction'),
        ]);

        return redirect()->route('dashboard.orders.travellers', $id);
    }

    public function travellerShow($orderId, $travellerId)
    {
        $order = Order::find($orderId);
        $traveller = $order->travellers()->find($travellerId);

        $data = [
            'title' => 'Order Traveller',
            'order' => $order,
            'traveller' => $traveller,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'orderStatuses' => OrderStatus::all(),
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList( $traveller->id )
        ];

        //dd($data['travellerFields']);

        return view('dashboard.orders.traveller.show', $data);
    }

    public function travellersEdit($orderId, $travellerId)
    {

    }

    public function travellersUpdate($orderId, $travellerId)
    {

    }

    public function travellersDestroy($orderId, $travellerId)
    {
        
    }





}
