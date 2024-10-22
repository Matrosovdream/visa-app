<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Helpers\adminSettingsHelper;

class DashboardHomeController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Admin Panel',
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.index', $data);
    }

}
