<?php
namespace App\Http\Controllers\User;

use App;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepo;
use App\Repositories\Geo\TravelDirectionRepo;
use App\Repositories\Geo\CountryRepo;
use Illuminate\Http\Request;
use App\Helpers\userSettingsHelper;
use App\Services\CurrencyConverterService;
use App\Services\GlobalsService;

class CountryController extends Controller
{
    public function __construct(
        private ProductRepo $productRepo,
        private TravelDirectionRepo $directionRepo,
        private CountryRepo $countryRepo
    ) {}

    public function index(Request $request)
    {
        $data = $this->getDirectionData($request);

        if (empty($data['country']) || empty($data['countryFrom'])) {
            return redirect()->route('web.index')
                ->with('error', 'Unknown country or nationality.');
        }

        if (empty($data['direction'])) {
            return redirect()->route('web.index')
                ->with('error', 'No visa information is available for this country pair.');
        }

        return view('web.country.index', $data);
    }

    public function apply(Request $request, GlobalsService $globalsService)
    {
        $data = $this->getDirectionData($request);

        $product = $this->productRepo->getByID($request->product_id);
        $data['product'] = $product['Model'];
        $data['totalPrice'] = $data['product']->offers->first()->price;
        $data['currency'] = $globalsService->getActiveCurrency()->code;
        $data['extrasPrice'] = $data['product']->extras->sum('price');

        $data['totalPrice'] = CurrencyConverterService::convert('USD', $data['currency'], $data['totalPrice']);
        $data['extrasPrice'] = CurrencyConverterService::convert('USD', $data['currency'], $data['extrasPrice']);

        $offers = $data['product']->offers;
        foreach ($offers as $offer) {
            $offer->price = CurrencyConverterService::convert('USD', $data['currency'], $offer->price);
        }
        $data['product']->offers = $offers;

        foreach ($data['product']->offers as $offer) {
            $offer->price = $offer->price + $data['extrasPrice'];
        }

        $extras = $data['product']->extras;
        foreach ($extras as $extra) {
            $extra->price = CurrencyConverterService::convert('USD', $data['currency'], $extra->price);
        }
        $data['product']->extras = $extras;

        if ($data['country']) {
            return view('web.country.apply', $data);
        }
    }

    public function findCountry($slug)
    {
        $result = $this->countryRepo->findBySlug($slug);
        return $result ? $result['Model'] : null;
    }

    public function getCountries($slug = null)
    {
        $countries = $this->countryRepo->getModel()->all();
        return $countries->filter(function ($country) use ($slug) {
            return $country->slug != $slug;
        });
    }

    public function getDirectionData($request)
    {
        $countryTo = $this->findCountry($request->country);
        $countryFrom = $this->findCountry($request->nationality);

        $direction = [];
        $products = [];

        if (isset($countryFrom) && isset($countryTo)) {
            $dirResult = $this->directionRepo->findPair($countryFrom->id, $countryTo->id);
            $direction = $dirResult ? $dirResult['Model'] : null;

            $products = [];
            if ($direction) {
                foreach ($direction->products as $productCountry) {
                    $found = $this->productRepo->getByID($productCountry->product_id);
                    if ($found) {
                        $products[] = $found['Model'];
                    }
                }
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
