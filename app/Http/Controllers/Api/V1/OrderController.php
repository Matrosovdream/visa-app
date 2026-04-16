<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepo;
use App\Repositories\Traveller\TravellerRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepo $orderRepo,
        private TravellerRepo $travellerRepo,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderRepo->getByUser($request->user()->id);

        return response()->json(['data' => $orders]);
    }

    public function show(int $orderId, Request $request): JsonResponse
    {
        $order = $this->orderRepo->getByID($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json(['data' => $order]);
    }

    public function preview(string $orderHash): JsonResponse
    {
        $order = $this->orderRepo->getByHash($orderHash);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json(['data' => $order]);
    }

    public function tripDetails(int $orderId): JsonResponse
    {
        $order = $this->orderRepo->getByID($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json(['data' => $order]);
    }

    public function updateTripDetails(int $orderId, Request $request): JsonResponse
    {
        $order = $this->orderRepo->getByID($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $model = $order['Model'];

        foreach ($request->input('meta', []) as $key => $value) {
            $model->setMeta($key, $value);
        }

        return response()->json(['data' => $this->orderRepo->getByID($orderId)]);
    }

    public function documents(int $orderId): JsonResponse
    {
        $order = $this->orderRepo->getByID($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $travellers = $order['Model']->travellers;

        return response()->json(['data' => [
            'order' => $order,
            'travellers' => $travellers,
        ]]);
    }

    // Applicant endpoints

    public function applicantDocuments(int $orderId, int $applicantId): JsonResponse
    {
        $traveller = $this->travellerRepo->getByID($applicantId);

        if (!$traveller) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        return response()->json(['data' => $traveller]);
    }

    public function storeApplicantDocuments(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        $traveller = $this->travellerRepo->getByID($applicantId);

        if (!$traveller) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        return response()->json(['data' => $traveller]);
    }

    public function deleteApplicantDocument(int $orderId, int $applicantId, int $documentId): JsonResponse
    {
        return response()->json(['message' => 'Document deleted.']);
    }

    public function updateApplicantFields(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        $traveller = $this->travellerRepo->getByID($applicantId);

        if (!$traveller) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        foreach ($request->input('fields', []) as $key => $value) {
            $traveller['Model']->setMeta($key, $value);
        }

        return response()->json(['data' => $this->travellerRepo->getByID($applicantId)]);
    }

    public function applicantPersonal(int $orderId, int $applicantId): JsonResponse
    {
        return $this->getApplicantSection($applicantId);
    }

    public function updateApplicantPersonal(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        return $this->updateApplicantSection($applicantId, $request);
    }

    public function applicantPassport(int $orderId, int $applicantId): JsonResponse
    {
        return $this->getApplicantSection($applicantId);
    }

    public function updateApplicantPassport(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        return $this->updateApplicantSection($applicantId, $request);
    }

    public function applicantFamily(int $orderId, int $applicantId): JsonResponse
    {
        return $this->getApplicantSection($applicantId);
    }

    public function updateApplicantFamily(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        return $this->updateApplicantSection($applicantId, $request);
    }

    public function applicantPastTravel(int $orderId, int $applicantId): JsonResponse
    {
        return $this->getApplicantSection($applicantId);
    }

    public function updateApplicantPastTravel(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        return $this->updateApplicantSection($applicantId, $request);
    }

    public function applicantDeclarations(int $orderId, int $applicantId): JsonResponse
    {
        return $this->getApplicantSection($applicantId);
    }

    public function updateApplicantDeclarations(int $orderId, int $applicantId, Request $request): JsonResponse
    {
        return $this->updateApplicantSection($applicantId, $request);
    }

    private function getApplicantSection(int $applicantId): JsonResponse
    {
        $traveller = $this->travellerRepo->getByID($applicantId);

        if (!$traveller) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        return response()->json(['data' => $traveller]);
    }

    private function updateApplicantSection(int $applicantId, Request $request): JsonResponse
    {
        $traveller = $this->travellerRepo->getByID($applicantId);

        if (!$traveller) {
            return response()->json(['message' => 'Applicant not found.'], 404);
        }

        foreach ($request->input('fields', []) as $key => $value) {
            $traveller['Model']->setMeta($key, $value);
        }

        return response()->json(['data' => $this->travellerRepo->getByID($applicantId)]);
    }
}
