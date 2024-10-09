<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelDirection;

class AdminDirectionsController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Directions',
            'directions' => TravelDirection::all()
        ];

        return view('admin.directions.index', $data);
    }

}
