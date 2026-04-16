<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepo;
use App\Helpers\adminSettingsHelper;

class AdminUsersController extends Controller
{
    public function __construct(private UserRepo $userRepo) {}

    public function index()
    {
        $result = $this->userRepo->getAll([], 10);

        $data = [
            'title' => 'Users',
            'users' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.users.index', $data);
    }

    public function show($user_id)
    {
        $user = $this->userRepo->getByID($user_id);

        $data = [
            'title' => 'User details',
            'user' => $user['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('admin.users.show', $data);
    }

    public function destroy($user_id)
    {
        $this->userRepo->delete($user_id);
        return redirect()->route('admin.users.index');
    }
}
