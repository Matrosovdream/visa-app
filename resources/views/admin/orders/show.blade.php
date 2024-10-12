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
                                    {{ $order->payment_method_id }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-truck fs-2 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>Shipping Method
                                    </div>
                                </td>
                                <td class="fw-bold text-end">Flat Shipping Rate</td>
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
                                            class="text-gray-600 text-hover-primary">Dan Wilson</a>
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
                                    <a href="apps/user-management/users/view.html"
                                        class="text-gray-600 text-hover-primary">dam@consilting.com</a>
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
                                <td class="fw-bold text-end">+6141 234 567</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="card card-flush py-4 flex-row-fluid">

            <div class="card-header">
                <div class="card-title">
                    <h2>Documents</h2>
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
                                        </i>Invoice
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="View the invoice generated by this order.">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </div>
                                </td>
                                <td class="fw-bold text-end">
                                    <a href="apps/invoices/view/invoice-3.html"
                                        class="text-gray-600 text-hover-primary">#INV-000414</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
            <div class="d-flex flex-column gap-7 gap-lg-10">

                <div class="card card-flush py-4 flex-row-fluid overflow-hidden">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Order #14534</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-175px">Product</th>
                                        <th class="min-w-100px text-end">SKU</th>
                                        <th class="min-w-70px text-end">Qty</th>
                                        <th class="min-w-100px text-end">Unit Price</th>
                                        <th class="min-w-100px text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-5">
                                                    <a href="apps/ecommerce/catalog/edit-product.html"
                                                        class="fw-bold text-gray-600 text-hover-primary">Product 1</a>
                                                    <div class="fs-7 text-muted">Delivery Date: 12/08/2024</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">02750005</td>
                                        <td class="text-end">2</td>
                                        <td class="text-end">$120.00</td>
                                        <td class="text-end">$240.00</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <!--begin::Thumbnail-->
                                                <a href="apps/ecommerce/catalog/edit-product.html"
                                                    class="symbol symbol-50px">
                                                    <span class="symbol-label"
                                                        style="background-image:url(assets/media//stock/ecommerce/100.png);"></span>
                                                </a>
                                                <!--end::Thumbnail-->
                                                <!--begin::Title-->
                                                <div class="ms-5">
                                                    <a href="apps/ecommerce/catalog/edit-product.html"
                                                        class="fw-bold text-gray-600 text-hover-primary">Footwear</a>
                                                    <div class="fs-7 text-muted">Delivery Date: 12/08/2024</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </td>
                                        <td class="text-end">01222005</td>
                                        <td class="text-end">1</td>
                                        <td class="text-end">$24.00</td>
                                        <td class="text-end">$24.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">Subtotal</td>
                                        <td class="text-end">$264.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">VAT (0%)</td>
                                        <td class="text-end">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">Shipping Rate</td>
                                        <td class="text-end">$5.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="fs-3 text-gray-900 text-end">Grand Total</td>
                                        <td class="text-gray-900 fs-3 fw-bolder text-end">$269.00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
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
                                        <th class="min-w-100px">Date Added</th>
                                        <th class="min-w-175px">Comment</th>
                                        <th class="min-w-70px">Order Status</th>
                                        <th class="min-w-100px">Customer Notifed</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">

                                    <tr>
                                        <td>12/08/2024</td>
                                        <td>Order completed</td>
                                        <td>
                                            <div class="badge badge-light-success">Completed</div>
                                        </td>
                                        <td>No</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card card-flush py-4 flex-row-fluid">

                    <div class="card-header">
                        <div class="card-title">
                            <h2>Order Data</h2>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">IP Address</td>
                                        <td class="fw-bold text-end">172.68.221.26</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Forwarded IP</td>
                                        <td class="fw-bold text-end">89.201.163.49</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">User Agent</td>
                                        <td class="fw-bold text-end">Mozilla/5.0 (Windows NT 10.0; Win64; x64)
                                            AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Accept Language</td>
                                        <td class="fw-bold text-end">en-GB,en-US;q=0.9,en;q=0.8</td>
                                    </tr>
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