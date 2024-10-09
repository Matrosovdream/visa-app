<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;

class AdminCountriesController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Countries',
            'countries' => Country::all()
        ];

        return view('admin.countries.index', $data);
    }

}
