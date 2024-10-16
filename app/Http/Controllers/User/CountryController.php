<?php
namespace App\Http\Controllers\User;

use App;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TravelDirection;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Helpers\userSettingsHelper;
use App\Services\LocationService;

class CountryController extends Controller
{

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    
    public function index(Request $request)
    {

        $data = $this->getDirectionData( $request );

        if ( $data['country'] ) {
            return view('user.country.index', $data);
        } 

    }

    public function apply(Request $request)
    {

        $data = $this->getDirectionData( $request );

        $data['product'] = Product::find($request->product_id);

        if ( $data['country'] ) {
            return view('user.country.apply', $data);
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

    public function getDirectionData( $request ) {

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
            'currency' => 'USD',
            'menuTop' => userSettingsHelper::getTopMenu(),
        ];

        return $data;

    }

}
