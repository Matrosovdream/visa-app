<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Helpers\adminSettingsHelper;

class AdminCountriesController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Countries',
            'countries' => Country::paginate(30),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.countries.index', $data);
    }

}
