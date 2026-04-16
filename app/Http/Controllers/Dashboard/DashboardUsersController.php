<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepo;
use App\Repositories\User\RoleRepo;
use App\Helpers\adminSettingsHelper;
use Illuminate\Http\Request;

class DashboardUsersController extends Controller
{
    public function __construct(
        private UserRepo $userRepo,
        private RoleRepo $roleRepo
    ) {}

    public function index()
    {
        $result = $this->userRepo->getAll([], 10);

        $data = [
            'title' => 'Users',
            'users' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.users.index', $data);
    }

    public function show($user_id)
    {
        $user = $this->userRepo->getByID($user_id);
        $roles = $this->roleRepo->getAll([], 100);

        $data = [
            'title' => 'User details',
            'user' => $user['Model'],
            'roles' => $roles['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.users.show', $data);
    }

    public function update($user_id, Request $request)
    {
        if ($request->action == 'save_general') {
            $request->validate([
                'name' => 'required',
                'role' => 'required',
            ]);

            $this->userRepo->update($user_id, request()->all());
            $user = $this->userRepo->getByID($user_id);
            $user['Model']->setRole($request->role);

            return redirect()->route('dashboard.users.index');
        }

        if ($request->action == 'save_password') {
            $request->validate([
                'password' => 'required',
            ]);

            $user = $this->userRepo->getByID($user_id);
            $user['Model']->password = bcrypt($request->password);
            $user['Model']->save();

            return redirect()->route('dashboard.users.index');
        }

        $this->userRepo->update($user_id, request()->all());
        return redirect()->route('dashboard.users.index');
    }

    public function create()
    {
        $roles = $this->roleRepo->getAll([], 100);

        $data = [
            'title' => 'Create user',
            'roles' => $roles['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];

        return view('dashboard.users.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required:email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $result = $this->userRepo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $result['Model']->setRole($request->role);

        return redirect()->route('dashboard.users.index');
    }

    public function destroy($user_id)
    {
        $this->userRepo->delete($user_id);
        return redirect()->route('dashboard.users.index');
    }
}
