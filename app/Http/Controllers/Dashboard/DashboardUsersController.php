<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\adminSettingsHelper;

class DashboardUsersController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Users',
            'users' => User::paginate(10),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.users.index', $data);
    }

    public function show($user_id)
    {
        $user = User::find($user_id);

        $data = [
            'title' => 'User details',
            'user' => $user,
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.users.show', $data);
    }

    public function destroy($user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        return redirect()->route('dashboard.users.index');
    }

}
