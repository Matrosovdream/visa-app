<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Helpers\adminSettingsHelper;

class AdminGatewaysController extends Controller
{
    
    public function index()
    {
        $data = [
            'title' => 'Payment Gateways',
            'gateways' => PaymentGateway::paginate(10),
            'sidebarMenu' => adminSettingsHelper::getSidebarMenu(),
        ];
        return view('admin.gateways.index', $data);
    }

}
