<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Helpers\adminSettingsHelper;
use App\Models\Product;
use App\Models\Country;
use Str;

class DashboardProductsController extends Controller
{
    
    public function index()
    {

        $perPage = 10;

        $data = [
            'title' => 'Products',
            'products' => Product::paginate(10),
            'perPage' => $perPage,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.products.index', $data);
    }

    public function show($id)
    {
        $product = Product::find($id);

        $data = [
            'title' => 'Product',
            'product' => $product,
            'countries' => Country::all(),
            'productFields' => $this->getProductFields( $product ),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.products.show', $data);
    }

    public function edit($id)
    {
        $product = Product::find($id);

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
            'countries' => Country::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'productFields' => $this->getProductFields(),
        ];

        return view('dashboard.products.edit', $data);
    }

    public function update($id)
    {
        $product = Product::find($id);

        $product->name = request('product_name');
        $product->description = request('description');
        $product->price = request('price');
        $product->published = ( request('status') == 'published' ) ? 1 : 0;
        $product->save();

        // Sync countries
        $product->countries()->sync(request('countries'));

        // Create meta fields
        foreach( request('fields') as $field=>$value ) {
            $product->updateMeta( $field, $value );
        }

        // Offers sync
        foreach( request('offers') as $offer ) {
            $product->offers()->create([
                'name' => $offer['name'],
                'price' => $offer['price'],
            ]);
        }

        return redirect()->route('dashboard.products.show', $id);
    }

    public function store()
    {
        $product = new Product();

        $product->name = request('product_name');
        $product->slug = Str::slug(request('product_name'));
        $product->description = request('description');
        $product->price = request('price');
        $product->published = ( request('status') == 'published' ) ? 1 : 0;
        $product->save();

        return redirect()->route('dashboard.products.index');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('dashboard.products.index');
    }

    public function create()
    {
        $data = [
            'title' => 'Create Product',
            'countries' => Country::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.products.create', $data);
    }

    public function getProductFields( $product=null ) {

        $fields = [
            ['slug' => 'valid_for', 'title' => 'Valid For (days)', 'type' => 'text', 'value' => ''],
            ['slug' => 'entries_number', 'title' => 'Number entries', 'type' => 'text', 'value' => ''],
            ['slug' => 'max_stay', 'title' => 'Max stay (days)', 'type' => 'text', 'value' => ''],
        ];

        if( isset($product) ) {
            foreach ($fields as $key => $field) {
                $fields[$key]['value'] = $product->getMeta($field['slug']);
            }
        }

        return $fields;

    }


}
