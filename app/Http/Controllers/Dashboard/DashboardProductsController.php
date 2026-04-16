<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Helpers\adminSettingsHelper;
use App\Repositories\Product\ProductRepo;
use App\Repositories\Geo\CountryRepo;
use Str;

class DashboardProductsController extends Controller
{
    public $perPage = 10;

    public function __construct(
        private ProductRepo $productRepo,
        private CountryRepo $countryRepo
    ) {}

    public function index()
    {
        $perPage = $this->perPage;

        if (request('s')) {
            $result = $this->productRepo->search(request('s'), $perPage);
        } else {
            $result = $this->productRepo->getAll([], $perPage);
        }

        $data = [
            'title' => 'Products',
            'products' => $result['Model'],
            'perPage' => $perPage,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.products.index', $data);
    }

    public function show($id)
    {
        $product = $this->productRepo->getByID($id);
        $countries = $this->countryRepo->getAll([], 300);

        $data = [
            'title' => 'Product',
            'product' => $product['Model'],
            'countries' => $countries['Model'],
            'productFields' => $this->getProductFields($product['Model']),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.products.show', $data);
    }

    public function edit($id)
    {
        $product = $this->productRepo->getByID($id);
        $countries = $this->countryRepo->getAll([], 300);

        $data = [
            'title' => 'Edit Product',
            'product' => $product['Model'],
            'countries' => $countries['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'productFields' => $this->getProductFields(),
        ];

        return view('dashboard.products.edit', $data);
    }

    public function update($id)
    {
        $product = $this->productRepo->getByID($id);
        $model = $product['Model'];

        $model->name = request('product_name');
        $model->description = request('description');
        $model->price = '0.00';
        $model->published = (request('status') == 'published') ? 1 : 0;
        $model->save();

        $model->countries()->sync(request('countries'));

        foreach (request('fields') as $field => $value) {
            $model->updateMeta($field, $value);
        }

        return redirect()->route('dashboard.products.show', $id);
    }

    public function store()
    {
        $result = $this->productRepo->create([
            'name' => request('product_name'),
            'slug' => Str::slug(request('product_name')),
            'description' => request('description'),
            'price' => request('price'),
            'published' => (request('status') == 'published') ? 1 : 0,
        ]);

        return redirect()->route('dashboard.products.index');
    }

    public function destroy($id)
    {
        $this->productRepo->delete($id);
        return redirect()->route('dashboard.products.index');
    }

    public function create()
    {
        $countries = $this->countryRepo->getAll([], 300);

        $data = [
            'title' => 'Create Product',
            'countries' => $countries['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.products.create', $data);
    }

    public function getProductFields($product = null)
    {
        $fields = [
            ['slug' => 'valid_for', 'title' => 'Valid For (days)', 'type' => 'text', 'value' => ''],
            ['slug' => 'entries_number', 'title' => 'Number entries', 'type' => 'text', 'value' => ''],
            ['slug' => 'max_stay', 'title' => 'Max stay (days)', 'type' => 'text', 'value' => ''],
        ];

        if (isset($product)) {
            foreach ($fields as $key => $field) {
                $fields[$key]['value'] = $product->getMeta($field['slug']);
            }
        }

        return $fields;
    }
}
