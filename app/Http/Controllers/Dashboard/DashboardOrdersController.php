<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Helpers\adminSettingsHelper;
use App\Models\OrderStatus;
use App\Helpers\TravellerHelper;
use App\Models\Traveller;
use App\Models\TravellerDocuments;
use App\Models\User;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Request;

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
            //'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            //'travellerFields' => TravellerHelper::getTravellerFieldList( $traveller->id )
        ];

        return view('dashboard.orders.show', $data);
    }

    public function edit($id)
    {
        $order = Order::find($id);

        $data = [
            'title' => 'Edit Order',
            'order' => $order,
            'orderStatuses' => OrderStatus::all(),
            'Users' => User::all(),
            'countries' => Country::all(),
            'currencies' => Currency::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        //dd($data);

        return view('dashboard.orders.edit', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Create Order',
            'orderStatuses' => OrderStatus::all(),
            'Users' => User::all(),
            'countries' => Country::all(),
            'currencies' => Currency::all(),
            'products' => Product::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        //dd($data);

        return view('dashboard.orders.create', $data);
    }

    public function store(Request $request)
    {
        
        // Create order
        $order = Order::create($request->fields);

        // Create cart
        


        // Meta
        foreach( $request->meta as $meta => $value ) {
            $order->setMeta($meta, $value);
        }   

        return redirect()->route('dashboard.orders.edit', $order->id)->with('success', 'Order created');
    }

    public function update(Order $order, Request $request)
    {
        
        //dd($order, $request->all());

        // Update fields
        $order->update($request->fields);

        // Meta
        foreach( $request->meta as $meta => $value ) {
            $order->setMeta($meta, $value);
        }   

        return redirect()->back()->with('success', 'Order updated');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route('dashboard.orders.index');
    }

    public function travellersCreate(Order $order)
    {

        $travellerFields = TravellerHelper::getTravellerFieldList();
        //dd($travellerFields);


        $data = [
            'title' => 'Order Traveller',
            'order' => $order,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'orderStatuses' => OrderStatus::all(),
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList()
        ];

        return view('dashboard.orders.traveller.create', $data);
    }

    public function travellersStore(Order $order, Request $request)
    {

        $request->validate([
            'fields.name' => 'required',
            'fields.lastname' => 'required',
            'fields.birthday' => 'required',
            'fields.passport' => 'required',
        ]);

        $traveller = new Traveller();
        $traveller->name = $request->input('fields.name');
        $traveller->lastname = $request->input('fields.lastname');
        $traveller->birthday = $request->input('fields.birthday');
        $traveller->passport = $request->input('fields.passport');
        $traveller->save();

        // Sync with the order
        $order->travellers()->sync($traveller->id);

        foreach( $request->fields as $field => $value ) {
            
            // Get field
            $field = TravellerHelper::getTravellerField($field);

            // Validate field and Update field
            if( isset($field) ) {
                TravellerHelper::updateTravellerField($traveller->id, $field, $value);
            } 

        }

        return redirect()->route('dashboard.orders.traveller.edit', [$order->id, $traveller->id]);
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

    public function travellerEdit($orderId, $travellerId)
    {
        $order = Order::find($orderId);
        $traveller = $order->travellers()->find($travellerId);

        $data = [
            'title' => 'Edit Order Traveller',
            'order' => $order,
            'traveller' => $traveller,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'orderStatuses' => OrderStatus::all(),
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList( $traveller->id )
        ];

        return view('dashboard.orders.traveller.edit', $data);

    }

    public function travellerUpdate(Order $order, Traveller $traveller, Request $request)
    {

        foreach( $request->fields as $field => $value ) {
            
            // Get field
            $field = TravellerHelper::getTravellerField($field);

            // Validate field and Update field
            if( isset($field) ) {
                TravellerHelper::updateTravellerField($traveller->id, $field, $value);
            } 

        }

        return redirect()->route('dashboard.orders.traveller.edit', [$order->id, $traveller->id]);

    }

    public function travellersDestroy(Order $order, Traveller $traveller, Request $request)
    {
        $traveller->delete();
        return redirect()->back()->with('success', 'Traveller deleted');
    }

    public function travellerDocumentStore(Order $order, Traveller $traveller, Request $request)
    {
        
        // Store the file in the 'uploads' directory
        if ($request->hasFile('document')) {

            $data = ['description' => $request->description, 'order_id' => $order->id];
            TravellerHelper::uploadDocument( 
                $traveller->id, 
                $request_file = 'document',
                $data
            );

        }

        return redirect()->back()->with('success', 'Document uploaded');
    }

    public function travellerDocumentDestroy(Order $order, Traveller $traveller, TravellerDocuments $document)
    {
        $document->delete();
        return redirect()->back()->with('success', 'Document deleted');
    }

}
