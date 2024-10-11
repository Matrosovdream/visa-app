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
            'directions' => TravelDirection::all(),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.directions.index', $data);
    }

}
