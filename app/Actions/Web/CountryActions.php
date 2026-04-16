<?php
namespace App\Actions\Web;

use Illuminate\Support\Facades\Auth;
use App\Models\Geo\Country;
use App\Models\Product\Product;
use App\Models\Geo\TravelDirection;
use App\Services\CurrencyConverterService;

class CountryActions
{
    public static function getDirectionData($request)
    {
        $data = array();

        $data['country'] = Country::where('slug', $request->slug)->first();
        $data['directions'] = TravelDirection::where('country_id', $data['country']->id)->get();
        $data['products'] = Product::where('country_id', $data['country']->id)->get();
        $data['currency'] = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'USD';

        return $data;
    }

    public static function apply($request)
    {
        $data = self::getDirectionData($request);

        $data['product'] = Product::find($request->product_id);
        $data['totalPrice'] = $data['product']->offers->first()->price + $data['product']->extras->sum('price');
        $data['currency'] = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'USD';
        $data['extrasPrice'] = $data['product']->extras->sum('price');

        $data['totalPrice'] = CurrencyConverterService::convert('USD', $data['currency'], $data['totalPrice']);
        $data['extrasPrice'] = CurrencyConverterService::convert('USD', $data['currency'], $data['extrasPrice']);

        $offers = $data['product']->offers;
        foreach ($offers as $offer) {
            $offer->price = CurrencyConverterService::convert('USD', $data['currency'], $offer->price);
        }
        $data['product']->offers = $offers;

        $extras = $data['product']->extras;
        foreach ($extras as $extra) {
            $extra->price = CurrencyConverterService::convert('USD', $data['currency'], $extra->price);
        }
        $data['product']->extras = $extras;

        if ($data['country']) {
            return view('web.country.apply', $data);
        }
    }
}
