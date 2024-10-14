<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelDirection;
use App\Helpers\adminSettingsHelper;

class AdminDirectionsController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Directions',
            'directions' => TravelDirection::paginate(30),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.directions.index', $data);
    }

    public function show($direction_id)
    {
        $direction = TravelDirection::find($direction_id);

        $data = [
            'title' => 'Direction',
            'direction' => $direction,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.directions.show', $data);
    }

}
