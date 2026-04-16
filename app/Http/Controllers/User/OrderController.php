<?php
namespace App\Http\Controllers\User;

use App\Actions\Web\OrderActions;
use App\Actions\Web\OrderApplicantActions as ApplicantActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Order\OrderRepo;
use App\Repositories\Traveller\TravellerRepo;
use App\Models\Traveller\TravellerDocuments;
use Illuminate\Support\Facades\Auth;
use App\Helpers\TravellerHelper;
use App\Helpers\orderHelper;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepo $orderRepo,
        private TravellerRepo $travellerRepo
    ) {}

    public function index()
    {
        $result = $this->orderRepo->getByUser(Auth::user()->id, 10);
        $data = array('title' => '', 'orders' => $result['Model']);
        return view('web.account.orders.index', $data);
    }

    public function show($order_id)
    {
        $order = $this->orderRepo->getByID($order_id);
        $data = array('title' => '', 'order' => $order['Model']);
        return view('web.account.orders.show', $data);
    }

    public function documents($order_id)
    {
        $order = $this->orderRepo->getByID($order_id);
        $data = array('title' => '', 'order' => $order['Model']);
        return view('web.account.orders.documents', $data);
    }

    public function showPreview($order_hash)
    {
        $order = $this->orderRepo->getByHash($order_hash);

        if (request()->has('lg')) {
            dd($order['Model']->getCart());
        }

        $data = array('title' => '', 'order' => $order['Model']);
        return view('web.order.show', $data);
    }

    public function tripDetails($order_id)
    {
        $order = $this->orderRepo->getByID($order_id);
        $data = array(
            'title' => '',
            'order' => $order['Model'],
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList()
        );
        return view('web.account.orders.trip', $data);
    }

    public function tripDetailsUpdate(Request $request, $order_id)
    {
        $order = $this->orderRepo->getByID($order_id);
        $model = $order['Model'];

        $model->setMeta('phone', $request->phone);
        $model->setMeta('time_arrival', $request->time_arrival);
        $model->setMeta('country_from_id', $request->country_from);

        orderHelper::checkUpdateStatus($order_id);

        return redirect()->route('web.account.order.trip', $order_id);
    }

    public function applicantDocuments($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.documents', $this->getApplicantData($order_id, $applicant_id));
    }

    public function applicantDocumentsUpdate(Request $request, $order_id, $applicant_id)
    {
        if ($request->hasFile('document')) {
            $data = ['description' => $request->description, 'order_id' => $order_id];
            TravellerHelper::uploadDocument(
                $applicant_id,
                $request_file = 'document',
                $data
            );
        }

        orderHelper::checkUpdateStatus($order_id);

        return redirect()->route('web.account.order.applicant.documents', [$order_id, $applicant_id]);
    }

    public function applicantDocumentDelete($order_id, $applicant_id, $document_id)
    {
        TravellerDocuments::find($document_id)->delete();
        return redirect()->route('web.account.order.applicant.documents', [$order_id, $applicant_id]);
    }

    public function applicantPersonal($order_id, $applicant_id)
    {
        return view('web.account.orders.applicant.personal', $this->getApplicantData($order_id, $applicant_id));
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
        orderHelper::checkUpdateStatus($order_id);
        return redirect()->back();
    }

    public function getApplicantData($order_id, $applicant_id)
    {
        $order = $this->orderRepo->getByID($order_id);
        $applicant = $this->travellerRepo->getByID($applicant_id);

        $fields = [
            'order' => $order['Model'],
            'applicant' => $applicant['Model'],
            'travellerFieldCategories' => TravellerHelper::getTravellerFieldCategories(),
            'travellerFields' => TravellerHelper::getTravellerFieldList($applicant_id)
        ];

        if (isset(request()->category)) {
            $fields['fields'] = TravellerHelper::getTravellerFieldList($applicant_id)[request()->category];
        }

        return $fields;
    }

    public function createApply(Request $request)
    {
        $order = OrderActions::createOrder($request);
        if (isset($order)) {
            return redirect()->route('web.order.show', $order->hash);
        } else {
            return redirect()->back();
        }
    }

    public function pay($hash)
    {
        $order = $this->orderRepo->getByHash($hash);
        $model = $order['Model'];

        $model->status_id = 2;
        $model->save();

        return redirect()->route('web.order.show', $model->hash);
    }
}
