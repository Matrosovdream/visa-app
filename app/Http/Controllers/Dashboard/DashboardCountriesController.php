<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Helpers\adminSettingsHelper;

class DashboardCountriesController extends Controller
{

    public $perPage = 30;
    
    public function index()
    {

        if( request('s') ) {
            $items = Country::search(request('s'))->paginate($this->perPage);
        } else {
            $items = Country::paginate($this->perPage);
        }

        $data = [
            'title' => 'Countries',
            'countries' => $items,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.countries.index', $data);
    }

}
