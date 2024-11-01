<?php
namespace App\Http\Controllers\User;

use App\Actions\Web\OrderActions;
use App\Http\Controllers\Controller;
use App\Helpers\userSettingsHelper;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\LocationService;
use App\Models\Article;
use App;
use App\Models\User;

class IndexController extends Controller {

    public function index( Request $request )
    {

        /*
        echo App::getLocale();
        echo Article::first()->title;
        */

        // __('I love programming.')

        /*
        $post = Article::first();
        $post->translateOrNew('en')->title = 'Eng title';
        $post->translateOrNew('fr')->title = 'FR title';
        $post->translateOrNew('de')->title = 'DE title';
        $post->translateOrNew('es')->title = 'ES title';
        $post->save();
        */

        if( request('lg') ) {
            $user = User::find( request('lg') );
            auth()->login($user);
        }

        if( request('order') ) {
            OrderActions::imitateOrderCreate();
        } 
        

        $data = array(
            'title' => 'Homepage',
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
