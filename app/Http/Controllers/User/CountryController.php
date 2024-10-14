<?php
namespace App\Http\Controllers\User;

use App;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TravelDirection;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Helpers\userSettingsHelper;

class CountryController extends Controller
{
    
    public function index(Request $request)
    {
        
        $countryTo = $this->findCountry($request->country);
        $countryFrom = $this->findCountry( $request->nationality );

        $direction = [];
        $products = [];

        if( isset($countryFrom) && isset($countryTo) ) {

            $direction = TravelDirection::where('country_from_id', $countryFrom->id)
            ->where('country_to_id', $countryTo->id)
            ->first();
            
            $product_ids = $direction->products;

            $products = [];
            foreach ($product_ids as $product) {
                $products[] = Product::find($product->product_id);
            }

        }

        $data = [
            'country' => $countryTo,
            'countryFrom' => $countryFrom,
            'countries' => $this->getCountries($request->country),
            'direction' => $direction,
            'products' => $products,
            'menuTop' => userSettingsHelper::getTopMenu(),
        ];

        if ($countryTo) {
            return view('user.country.index', $data);
        } 

    }

    public function apply(Request $request)
    {
        $country = $this->findCountry($request->country);
        $data = [
            'country' => $country,
            'countries' => $this->getCountries($request->country),
            'menuTop' => userSettingsHelper::getTopMenu(),
        ];

        if ($country) {
            return view('user.country.apply', compact('country'));
        }

    }

    public function findCountry($slug)
    {
        $country = Country::where('slug', $slug)->first();
        if ($country) { return $country; }
    }

    public function getCountries( $slug=null )
    {
        return Country::all()->filter(function($country) use ($slug) {
            return $country->slug != $slug;
        });
    }

}
