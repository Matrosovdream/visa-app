<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Helpers\userSettingsHelper;
use App\Models\Country;
use Illuminate\Http\Request;

class indexController extends Controller {
    
    public function index()
    {

        $data = array(
            'title' => 'Homepage',
            'menuTop' => userSettingsHelper::getTopMenu(),
            'countries' => Country::all(),
        );

        return view('user.index', $data);
    }

    public function directionApply( Request $request )
    {

        // We make a link kinda /country/{country_to}?nationality={country_from}
        $country_from = Country::find($request->country_from);
        $country_to = Country::find($request->country_to);

        return redirect()->route('user.country.index', 
            [
            'country' => $country_to->slug, 
            'nationality' => $country_from->slug
            ]
        );

    }

}
