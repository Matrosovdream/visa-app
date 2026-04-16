<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Geo\TravelDirectionRepo;
use App\Helpers\adminSettingsHelper;

class DashboardDirectionsController extends Controller
{
    public function __construct(private TravelDirectionRepo $directionRepo) {}

    public function index()
    {
        $result = $this->directionRepo->getAll([], 30);

        $data = [
            'title' => 'Directions',
            'directions' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.directions.index', $data);
    }

    public function show($direction_id)
    {
        $direction = $this->directionRepo->getByID($direction_id);

        $data = [
            'title' => 'Direction',
            'direction' => $direction['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.directions.show', $data);
    }
}
