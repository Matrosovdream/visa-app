@extends('admin.layouts.app')

@section('content')

<div class="d-flex flex-column gap-7 gap-lg-10">
    <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                    href="#kt_ecommerce_sales_order_summary">Order Summary</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                    href="#kt_ecommerce_sales_order_travellers">Travellers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                    href="#kt_ecommerce_sales_order_payments">Payments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                    href="#kt_ecommerce_sales_order_history">Order History</a>
            </li>
        </ul>

        <a href="apps/ecommerce/sales/listing.html"
            class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
            <i class="ki-duotone ki-left fs-2"></i>
        </a>
        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-success btn-sm me-lg-n7">Edit Order</a>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">Add New Order</a>

    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">

            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Order Details (#{{ $order->id }})</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">

                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-calendar fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Date Added
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-wallet fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>Payment Method
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->paymentMethod->name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Customer Details</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-profile-circle fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>Customer
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <a href="apps/ecommerce/customers/details.html"
                                                    class="text-gray-600 text-hover-primary">
                                                    {{ $order->customerFields()['full_name'] }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-sms fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Email
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->customerFields()['email'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-phone fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Phone
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->customerFields()['phone'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Trip details</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-devices fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                                Nationality
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->countryFrom()->name }} -
                                            {{ $order->countryFrom()->code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-devices fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                                Destination
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->countryTo()->name }} -
                                            {{ $order->countryTo()->code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-calendar fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Time arrival
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            {{ $order->customerFields()['time_arrival'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <br/><br/>

            <div class="d-flex flex-column gap-7 gap-lg-10 mt-35">

                <div class="card card-flush py-4 flex-row-fluid overflow-hidden">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Order #{{ $order->id }}</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-175px">Product</th>
                                        <th class="min-w-100px text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">

                                    @foreach($order->cartProducts as $item)

                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-5">
                                                        <a href="{{ route('admin.products.show', $item->product->id) }}"
                                                            class="fw-bold text-gray-600 text-hover-primary">
                                                            {{ $item->product->name }}
                                                            ( {{ $item->offer->name }} )
                                                        </a>
                                                        <div class="extras">
                                                            @foreach($item->product->extras as $extra)
                                                                <span class="">+ {{ $extra->name }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                {{ $item->total }}$
                                            </td>
                                        </tr>

                                    @endforeach

                                    <tr>
                                        <td colspan="1" class="text-end">Subtotal</td>
                                        <td class="text-end">
                                            {{ $order->getTotal() }}$
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="text-end">VAT (0%)</td>
                                        <td class="text-end">$0.00</td>
                                    </tr>

                                    <tr>
                                        <td colspan="1" class="fs-3 text-gray-900 text-end">Grand Total</td>
                                        <td class="text-gray-900 fs-3 fw-bolder text-end">
                                            {{ $order->getTotal() }}$
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="kt_ecommerce_sales_order_travellers" role="tab-panel">
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Travellers</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">

                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px">Name</th>
                                        <th class="min-w-175px">Last name</th>
                                        <th class="min-w-175px">Date of birth</th>
                                        <th class="min-w-175px">Passport</th>
                                        <th class="min-w-175px">Passport Exp</th>

                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">

                                    @foreach($order->getTravellers() as $traveller)

                                        <tr>
                                            <td>
                                                {{ $traveller['name'] }}
                                            </td>
                                            <td>
                                                {{ $traveller['lastname'] }}
                                            </td>
                                            <td>
                                                {{ $traveller['birthday'] }}
                                            </td>
                                            <td>
                                                {{ $traveller['passport'] }}
                                            </td>
                                            <td>
                                                <?php    /*
                                                       {{ $traveller['passport-expiration-day'] }}/
                                                       {{ $traveller['passport-expiration-month'] }}/
                                                       */?>
                                                {{ $traveller['passport-expiration-year'] }}
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="kt_ecommerce_sales_order_payments" role="tab-panel">
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Payments</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">

                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-175px">Gateway</th>
                                        <th class="min-w-175px">Transaction ID</th>
                                        <th class="min-w-175px">Amount</th>
                                        <th class="min-w-175px">Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">

                                    @foreach($order->payments as $payment)
                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                {{ $payment->gateway->name }}
                                            </td>
                                            <td>
                                                {{ $payment->transaction_id }}
                                            </td>
                                            <td>
                                                {{ $payment->amount }}
                                            </td>
                                            <td>
                                                {{ $payment->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Order History</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">

                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px">Date</th>
                                        <th class="min-w-175px">Comment</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">

                                    @foreach($order->history as $history)

                                        <tr>
                                            <td>
                                                {{ $history->created_at->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                {{ $history->comment }}
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>


@endsection