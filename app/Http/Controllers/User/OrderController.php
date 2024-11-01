<?php
namespace App\Http\Controllers\User;

use App\Actions\Web\OrderActions;
use App\Actions\Web\OrderApplicantActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Traveller;
use Illuminate\Support\Facades\Storage;
use App\Models\TravellerDocuments;
use App\Helpers\TravellerHelper;
use App\Actions\Web\OrderApplicantActions as ApplicantActions;


class OrderController extends Controller
{

    public function index()
    {
        $data = array( 'title' => '', 'orders' => Order::getOrdersByUser( Auth::user()->id )->paginate(10));
        return view('web.account.orders.index', $data);
    }

    public function show($order_id)
    {

        $data = array('title' => '', 'order' => Order::find($order_id));
        return view('web.account.orders.show', $data);
    }

    public function tripDetails($order_id)
    {
        $data = array(
            'title' => '',
            'order' => Order::find($order_id), 
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList()
        );
        return view('web.account.orders.trip', $data);
    }

    public function tripDetailsUpdate(Request $request, $order_id)
    {

        $order = Order::find($order_id);
        // Set meta
        $order->setMeta('phone', $request->phone);
        $order->setMeta('time_arrival', $request->time_arrival);
        $order->setMeta('country_from_id', $request->country_from);

        return redirect()->route('web.account.order.trip', $order_id);
    }

    public function applicantDocuments($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.documents', $this->getApplicantData($order_id, $applicant_id));
    }

    public function applicantDocumentsUpdate(Request $request, $order_id, $applicant_id)
    {


        $traveller = Traveller::find($applicant_id);    

        // Store the file in the 'uploads' directory
        if ($request->hasFile('document')) {
            $filePath = $request->file('document')->store('uploads/documents', 'public');

            // Optional: Get the file URL if needed
            $fileUrl = Storage::url($filePath);

            // Save the file path in the database
            $traveller->documents()->create([
                'type' => 'general',
                'filename' => $request->file('document')->getClientOriginalName(),
                'path' => $filePath,
                'description' => 'test',
            ]);

        }
        
        return redirect()->route('web.account.order.applicant.documents', [$order_id, $applicant_id]);
    }

    public function applicantDocumentDelete($order_id, $applicant_id, $document_id)
    {
        TravellerDocuments::find($document_id)->delete();
        return redirect()->route('web.account.order.applicant.documents', [$order_id, $applicant_id]);
    }

    public function applicantPassport($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.passport', $this->getApplicantData($order_id, $applicant_id));
    }

    public function applicantFamily($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.family', $this->getApplicantData($order_id, $applicant_id));
    }

    public function applicantPastTravel($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.past-travel', $this->getApplicantData($order_id, $applicant_id));
    }

    public function applicantDeclarations($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.declarations', $this->getApplicantData($order_id, $applicant_id));
    }

    public function applicantFieldsUpdate(Request $request, $order_id, $applicant_id)
    {

        ApplicantActions::fieldsUpdate($request, $order_id, $applicant_id);

        return redirect()->back();
    }

    public function getApplicantData($order_id, $applicant_id) {

        $fields = [
            'order' => Order::find($order_id), 
            'applicant' => Traveller::find($applicant_id),
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList( $applicant_id )
        ];

        if( isset( request()->category ) ) {
            $fields['fields'] = TravellerHelper::getTravellerFieldList($applicant_id)[ request()->category ];
        }

        return $fields;
    }

    public function createApply(Request $request)
    {

        $order = OrderActions::createOrder($request);
        if( isset($order) ) {
            return redirect()->route('web.order.show', $order->hash);
        } else {
            return redirect()->back();
        }

    }

    public function pay($hash)
    {
        $order = Order::getByHash($hash);

        // Payment processing
        

        // Change order status
        $order->status_id = 2;
        $order->save();

        // Redirect to the order page
        return redirect()->route('web.order.show', $order->hash);
    }

}
