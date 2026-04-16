<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepo;
use App\Repositories\Order\OrderStatusRepo;
use App\Repositories\User\UserRepo;
use App\Repositories\Geo\CountryRepo;
use App\Repositories\Geo\CurrencyRepo;
use App\Repositories\Product\ProductRepo;
use App\Models\Order\Order;
use App\Models\Traveller\Traveller;
use App\Models\Traveller\TravellerDocuments;
use App\Helpers\adminSettingsHelper;
use App\Helpers\TravellerHelper;
use Illuminate\Http\Request;

class DashboardOrdersController extends Controller
{
    public function __construct(
        private OrderRepo $orderRepo,
        private OrderStatusRepo $orderStatusRepo,
        private UserRepo $userRepo,
        private CountryRepo $countryRepo,
        private CurrencyRepo $currencyRepo,
        private ProductRepo $productRepo
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
        return view('dashboard.orders.index', $data);
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

        return view('dashboard.orders.show', $data);
    }

    public function edit($id)
    {
        $order = $this->orderRepo->getByID($id);
        $statuses = $this->orderStatusRepo->getAll([], 100);
        $users = $this->userRepo->getAll([], 300);
        $countries = $this->countryRepo->getAll([], 300);
        $currencies = $this->currencyRepo->getAll([], 100);

        $data = [
            'title' => 'Edit Order',
            'order' => $order['Model'],
            'orderStatuses' => $statuses['Model'],
            'Users' => $users['Model'],
            'countries' => $countries['Model'],
            'currencies' => $currencies['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.orders.edit', $data);
    }

    public function create()
    {
        $statuses = $this->orderStatusRepo->getAll([], 100);
        $users = $this->userRepo->getAll([], 300);
        $countries = $this->countryRepo->getAll([], 300);
        $currencies = $this->currencyRepo->getAll([], 100);
        $products = $this->productRepo->getAll([], 300);

        $data = [
            'title' => 'Create Order',
            'orderStatuses' => $statuses['Model'],
            'Users' => $users['Model'],
            'countries' => $countries['Model'],
            'currencies' => $currencies['Model'],
            'products' => $products['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.orders.create', $data);
    }

    public function store(Request $request)
    {
        $result = $this->orderRepo->create($request->fields);
        $order = $result['Model'];

        foreach ($request->meta as $meta => $value) {
            $order->setMeta($meta, $value);
        }

        return redirect()->route('dashboard.orders.edit', $order->id)->with('success', 'Order created');
    }

    public function update(Order $order, Request $request)
    {
        $order->update($request->fields);

        foreach ($request->meta as $meta => $value) {
            $order->setMeta($meta, $value);
        }

        return redirect()->back()->with('success', 'Order updated');
    }

    public function destroy($id)
    {
        $this->orderRepo->delete($id);
        return redirect()->route('dashboard.orders.index');
    }

    public function travellersCreate(Order $order)
    {
        $statuses = $this->orderStatusRepo->getAll([], 100);

        $data = [
            'title' => 'Order Traveller',
            'order' => $order,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'orderStatuses' => $statuses['Model'],
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

        $order->travellers()->sync($traveller->id);

        foreach ($request->fields as $field => $value) {
            $field = TravellerHelper::getTravellerField($field);
            if (isset($field)) {
                TravellerHelper::updateTravellerField($traveller->id, $field, $value);
            }
        }

        return redirect()->route('dashboard.orders.traveller.edit', [$order->id, $traveller->id]);
    }

    public function travellerShow($orderId, $travellerId)
    {
        $order = $this->orderRepo->getByID($orderId);
        $traveller = $order['Model']->travellers()->find($travellerId);
        $statuses = $this->orderStatusRepo->getAll([], 100);

        $data = [
            'title' => 'Order Traveller',
            'order' => $order['Model'],
            'traveller' => $traveller,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'orderStatuses' => $statuses['Model'],
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList($traveller->id)
        ];

        return view('dashboard.orders.traveller.show', $data);
    }

    public function travellerEdit($orderId, $travellerId)
    {
        $order = $this->orderRepo->getByID($orderId);
        $traveller = $order['Model']->travellers()->find($travellerId);
        $statuses = $this->orderStatusRepo->getAll([], 100);

        $data = [
            'title' => 'Edit Order Traveller',
            'order' => $order['Model'],
            'traveller' => $traveller,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'orderStatuses' => $statuses['Model'],
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList($traveller->id)
        ];

        return view('dashboard.orders.traveller.edit', $data);
    }

    public function travellerUpdate(Order $order, Traveller $traveller, Request $request)
    {
        foreach ($request->fields as $field => $value) {
            $field = TravellerHelper::getTravellerField($field);
            if (isset($field)) {
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
