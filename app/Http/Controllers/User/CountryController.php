<?php
namespace App\Http\Controllers\User;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    
    public function index(Request $request)
    {
        
        $country = $this->findCountry($request->country);
        $data = [
            'country' => $country,
            'countries' => $this->getCountries($request->country)
        ];

        if ($country) {
            return view('user.country.index', $data);
        } 

    }

    public function apply(Request $request)
    {
        $country = $this->findCountry($request->country);
        $data = [
            'country' => $country,
            'countries' => $this->getCountries($request->country)
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
