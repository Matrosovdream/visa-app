<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\userSettingsHelper;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\LocationService;
use App\Models\Article;
use App;

class IndexController extends Controller {

    public function index( Request $request )
    {

        $data = array(
            'title' => 'Homepage',
            'menuTop' => userSettingsHelper::getTopMenu(),
            'countries' => Country::all(),
            'articles' => Article::paginate(3),
            'location' => LocationService::getLocation( $request->ip() )
        );

        return view('web.index', $data);
    }

    public function directionApply( Request $request )
    {

        // We make a link kinda /country/{country_to}?nationality={country_from}
        $country_from = Country::find($request->country_from);
        $country_to = Country::find($request->country_to);

        return redirect()->route('web.country.index', 
            [
            'country' => $country_to->slug, 
            'nationality' => $country_from->slug
            ]
        );

    }

}
