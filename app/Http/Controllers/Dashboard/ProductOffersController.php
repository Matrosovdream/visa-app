<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductOffers;
use Illuminate\Http\Request;

class ProductOffersController extends Controller {


    public function index() {  }

    public function store(Request $request) {
        $productOffers = ProductOffers::create($request->all());
        return redirect()->back()->with("success","Product offer created successfully");
    }

    public function show($id) { }

    public function edit($id) { }

    public function update(Request $request, ProductOffers $productOffer) { 
        $productOffer->update($request->all());
        return redirect()->back()->with("success","Product offer updated successfully");
    }

    public function destroy(ProductOffers $productOffer) { 
        $productOffer->delete();
        return redirect()->back()->with("success","Product offer deleted successfully");

    }

}