<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Geo\CountryRepo;
use App\Helpers\adminSettingsHelper;

class DashboardCountriesController extends Controller
{
    public $perPage = 30;

    public function __construct(private CountryRepo $countryRepo) {}

    public function index()
    {
        if (request('s')) {
            $result = $this->countryRepo->search(request('s'), $this->perPage);
        } else {
            $result = $this->countryRepo->getAll([], $this->perPage);
        }

        $data = [
            'title' => 'Countries',
            'countries' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.countries.index', $data);
    }
}
