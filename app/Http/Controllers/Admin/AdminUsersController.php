<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUsersController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Users',
            'users' => User::all()
        ];

        return view('admin.users.index', $data);
    }

}
