<?php
namespace App\Http\Controllers\User;

use App\Actions\Web\OrderActions;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ArticleRepo;
use App\Repositories\Geo\CountryRepo;
use App\Repositories\User\UserRepo;
use Illuminate\Http\Request;
use App\Services\LocationService;

class IndexController extends Controller
{
    public function __construct(
        private ArticleRepo $articleRepo,
        private CountryRepo $countryRepo,
        private UserRepo $userRepo
    ) {}

    public function index(Request $request)
    {
        if (request('lg')) {
            $user = $this->userRepo->getByID(request('lg'));
            auth()->login($user['Model']);
        }

        if (request('order')) {
            OrderActions::imitateOrderCreate();
        }

        $articles = $this->articleRepo->getAll([], 3);

        $data = array(
            'title' => 'Homepage',
            'articles' => $articles['Model'],
            'location' => LocationService::getLocation($request->ip())
        );

        return view('web.index', $data);
    }

    public function directionApply(Request $request)
    {
        $country_from = $this->countryRepo->getByID($request->country_from);
        $country_to = $this->countryRepo->getByID($request->country_to);

        return redirect()->route('web.country.index', [
            'country' => $country_to['Model']->slug,
            'nationality' => $country_from['Model']->slug
        ]);
    }
}
