<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Payment\PaymentGatewayRepo;
use App\Helpers\adminSettingsHelper;

class DashboardGatewaysController extends Controller
{
    public function __construct(private PaymentGatewayRepo $gatewayRepo) {}

    public function index()
    {
        $result = $this->gatewayRepo->getAll([], 10);

        $data = [
            'title' => 'Payment Gateways',
            'gateways' => $result['Model'],
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];
        return view('dashboard.gateways.index', $data);
    }
}
