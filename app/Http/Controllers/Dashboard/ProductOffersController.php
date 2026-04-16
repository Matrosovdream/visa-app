<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductOffersRepo;
use App\Models\Product\ProductOffers;
use Illuminate\Http\Request;

class ProductOffersController extends Controller
{
    public function __construct(private ProductOffersRepo $offersRepo) {}

    public function index() {}

    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $result = $this->offersRepo->create($request->all());
        $result['Model']->setMetaSync($request->meta);

        return redirect()->back()->with("success", "Product offer created successfully");
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, ProductOffers $offer)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $offer->update($request->all());
        $offer->setMetaSync($request->meta);

        return redirect()->back()->with("success", "Product offer updated successfully");
    }

    public function destroy(ProductOffers $offer)
    {
        $offer->delete();
        return redirect()->back()->with("success", "Product offer deleted successfully");
    }
}
