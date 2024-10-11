<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\adminSettingsHelper;

class AdminHomeController extends Controller
{
    
    public function index()
    {

        $data = [
            'title' => 'Admin Panel',
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.index', $data);
    }

}
