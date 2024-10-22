<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Helpers\adminSettingsHelper;

class DashboardCountriesController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Countries',
            'countries' => Country::paginate(30),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.countries.index', $data);
    }

}
