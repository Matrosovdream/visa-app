<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Content\SiteSettingsRepo;
use Illuminate\Http\Request;
use App\Helpers\adminSettingsHelper;

class DashboardSettingsController extends Controller
{
    public function __construct(private SiteSettingsRepo $settingsRepo) {}

    public function index()
    {
        $data = [
            'title' => 'Settings',
            'page' => 'settings',
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
            'settings' => $this->settingsRepo->getSettings()
        ];

        return view('dashboard.settings.index', $data);
    }

    public function store(Request $request)
    {
        $settings = $this->settingsRepo->getSettingsList();

        foreach ($settings as $setting) {
            $this->settingsRepo->set($setting['key'], $request->input($setting['key']));
        }

        return redirect()->route('dashboard.settings.index')->with('success', 'Settings updated successfully');
    }
}
