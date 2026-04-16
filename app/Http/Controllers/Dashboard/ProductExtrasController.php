<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductExtrasRepo;
use App\Models\Product\ProductExtras;
use Illuminate\Http\Request;

class ProductExtrasController extends Controller
{
    public function __construct(private ProductExtrasRepo $extrasRepo) {}

    public function index() {}

    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $this->extrasRepo->create($request->all());

        return redirect()->back()->with("success", "Product offer created successfully");
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, ProductExtras $extra)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $extra->update($request->all());

        return redirect()->back()->with("success", "Product offer updated successfully");
    }

    public function destroy(ProductExtras $extra)
    {
        $extra->delete();
        return redirect()->back()->with("success", "Product offer deleted successfully");
    }
}
