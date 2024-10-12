<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\adminSettingsHelper;

class AdminUsersController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Users',
            'users' => User::paginate(10),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.users.index', $data);
    }

}
