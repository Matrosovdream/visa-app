@extends('admin.layouts.app')

@section('content')

<div class="card card-flush">

    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" data-kt-ecommerce-product-filter="search"
                    class="form-control form-control-solid w-250px ps-12" placeholder="Search Orders">
            </div>
        </div>

        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

            <div class="input-group w-250px">
                <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Pick date range"
                    id="kt_ecommerce_sales_flatpickr" />
                <button class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr_clear">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>

            <div class="w-100 mw-150px">

                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                    data-placeholder="Status" data-kt-ecommerce-order-filter="status">
                    <option></option>
                    @foreach($orderStatuses as $status)
                        <option value="{{ $status->slug }}">{{ $status->name }}</option>
                    @endforeach
                </select>

            </div>

            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Add Order</a>

        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="">ID</th>
                        <th class="">Customer</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Product</th>
                        <th class="text-center min-w-100px">Total</th>
                        <th class="text-center min-w-100px">Added</th>
                        <th class="text-center min-w-100px">Modified</th>
                        <th class="text-center min-w-70px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">

                    @foreach($orders as $order)

                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                        data-kt-ecommerce-product-filter="product_name">
                                        {{ $order->id }}
                                    </a>
                                </div>
                            </td>
                            <td>
                                @if( $order->user ) 
                                    {{ $order->user->name }}
                                @endif
                            </td>
                            <td class="text-center pe-0">
                                @if ($order->status->slug == 'pending')
                                    <div class="badge badge-light-primary">{{ $order->status->name }}</div>
                                @elseif ($order->status->slug == 'completed')
                                    <div class="badge badge-light-success">{{ $order->status->name }}</div>
                                @elseif ($order->status->slug == 'cancelled')
                                    <div class="badge badge-light-danger">{{ $order->status->name }}</div>
                                @else
                                    <div class="badge badge-light-primary">{{ $order->status->name }}</div>
                                @endif
                            </td>
                            <td class="text-center pe-0">

                                @foreach($order->cartProducts as $item)
                                    <a href="{{ route('admin.products.show', $item->product->id) }}"
                                        class="text-gray-800 text-hover-primary"
                                        data-kt-ecommerce-product-filter="product_name">
                                        {{ $item->product->name }}
                                        ( {{ $item->offer->name }} )
                                        <div class="extras">
                                            @foreach($item->product->extras as $extra)
                                                <span class="">+ {{ $extra->name }}</span>
                                            @endforeach
                                        </div>
                                    </a>
                                @endforeach

                            </td>
                            <td class="text-center pe-0">
                                {{ $order->getTotal() }}$
                            </td>
                            <td class="text-center pe-0" data-order="Inactive">
                                {{ $order->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center pe-0" data-order="Inactive">
                                {{ $order->updated_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">

                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.orders.edit', $order->id) }}"
                                                class="menu-link px-3">Edit</a>
                                        </div>

                                        <div class="menu-item px-3">
                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="menu-link px-3" type="submit">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>

                                    </div>

                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>


        <div id="" class="row">
            {{ $orders->links('admin.includes.pagination.default') }}
        </div>

    </div>

</div>

@endsection