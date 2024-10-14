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

    public function show($user_id)
    {
        $user = User::find($user_id);

        $data = [
            'title' => 'User details',
            'user' => $user,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.users.show', $data);
    }

    public function destroy($user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

}
