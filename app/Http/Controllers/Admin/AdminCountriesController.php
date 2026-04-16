<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Geo\CountryRepo;
use App\Helpers\adminSettingsHelper;

class AdminCountriesController extends Controller
{
    public function __construct(private CountryRepo $countryRepo) {}

    public function index()
    {
        $result = $this->countryRepo->getAll([], 30);

        $data = [
            'title' => 'Countries',
            'countries' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.countries.index', $data);
    }
}
