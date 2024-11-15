<div class="tab-pane fade @if (!request()->routeIs('dashboard.orders.traveller.*')) active show @endif"
    id="kt_ecommerce_sales_order_summary" role="tab-panel">

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
                                        </i>Status
                                    </div>
                                </td>
                                <td class="fw-bold text-end">
                                    {{ $order->status->name }}
                                </td>
                            </tr>
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
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-wallet fs-2 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>Payment Status
                                    </div>
                                </td>
                                <td class="fw-bold text-end">
                                    {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
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

    <br /><br />

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
                                <th class="min-w-100px text-end">Price</th>
                                <th class="min-w-100px text-end">Quantity</th>
                                <th class="min-w-100px text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">

                            @foreach($order->getCart() as $item)

                                <tr>
                                    <td class="min-w-175px">

                                        <a href="{{ route('dashboard.products.show', $item['product']['id']) }}"
                                            class="fw-bold text-gray-600 text-hover-primary">
                                            {{ $item['product']['name'] }} ({{ $item['offer']['name'] }})
                                        </a>

                                    </td>
                                    <td class="min-w-100px text-end">
                                        {{ $item['offer']['price'] }} {{ $order->getCurrency() }}
                                    </td>
                                    <td class="min-w-100px text-end">
                                        {{ $item['quantity'] }}
                                    </td>
                                    <td class="min-w-100px text-end">
                                        {{ $item['offer']['total'] }} {{ $order->getCurrency() }}
                                    </td>
                                </tr>

                                @foreach($item['extras'] as $extra)

                                    <tr>
                                        <td class="min-w-175px">
                                            {{ $extra['name'] }}
                                        </td>
                                        <td class="min-w-100px text-end">
                                            {{ $extra['price'] }} {{ $order->getCurrency() }}
                                        </td>
                                        <td class="min-w-100px text-end">
                                            {{ $extra['quantity'] }}
                                        </td>
                                        <td class="min-w-100px text-end">
                                            {{ $extra['total'] }} {{ $order->getCurrency() }}
                                        </td>
                                    </tr>

                                @endforeach

                            @endforeach


                        </tbody>
                    </table>
                    <!--end::Table-->
                    <br/>
                    <h3 class="mt-25">
                        {{ __('Total') }}: {{ $order->getTotal() }} {{ $order->getCurrency() }}
                    </h3>

                </div>
            </div>
        </div>
    </div>
</div>