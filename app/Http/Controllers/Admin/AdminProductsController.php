<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class AdminProductsController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Products',
            'products' => Product::all()
        ];

        return view('admin.products.index', $data);
    }

    public function show($id)
    {
        $product = Product::find($id);

        $data = [
            'title' => 'Product',
            'product' => $product
        ];

        return view('admin.products.show', $data);
    }


}
