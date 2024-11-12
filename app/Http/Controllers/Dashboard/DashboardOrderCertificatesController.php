<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OrderCertificate;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Helpers\OrderHelper;



class DashboardOrderCertificatesController extends Controller
{
    
    public function create(Request $request, Order $order)
    {

        if ($request->hasFile('document')) {

            $data = ['description' => $request->description, 'order_id' => $order->id];
            OrderHelper::uploadDocument( 
                $order->id, 
                $request_file = 'document',
                $data
            );

        }

        return redirect()->back()->with('success','Document uploaded successfully');

        
    }

    public function destroy(Order $order, OrderCertificate $certificate)
    {
        $certificate->delete();
        return redirect()->back()->with('success','Document deleted successfully');
    }
    

}
