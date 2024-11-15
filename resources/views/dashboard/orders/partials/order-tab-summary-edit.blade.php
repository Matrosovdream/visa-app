<div class="tab-pane fade @if (!request()->routeIs('dashboard.orders.traveller.*')) active show @endif"
    id="kt_ecommerce_sales_order_summary" role="tab-panel">

    <form method="POST" action="{{ route('dashboard.orders.update', $order->id) }}">
            @csrf

    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid">

            <div class="card-header">
                <div class="card-title">
                    <h2>Order Details (#{{ $order->id }})</h2>
                </div>
            </div>

            <div class="card-body pt-0">

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label  w-100">
                        Status *
                    </label>

                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                        data-placeholder="Status" data-kt-ecommerce-order-filter="status" name="fields[status_id]">
                        <option selected disabled></option>
                        @foreach($orderStatuses as $status)
                            <option value="{{ $status->id }}" @if($status->slug == $order->status->slug) selected @endif>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label  w-100">
                        Currency *
                    </label>

                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                        data-placeholder="Status" data-kt-ecommerce-order-filter="status" name="meta[currency]">
                        <option selected disabled></option>
                        @foreach($currencies as $item)
                            <option value="{{ $item->code }}" @if($item->code == $order->getMeta('currency')) selected @endif>
                                {{ $item->code }}
                            </option>
                        @endforeach
                    </select>
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

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label  w-100">
                        User *
                    </label>

                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                        data-placeholder="Status" data-kt-ecommerce-order-filter="status" name="fields[user_id]">
                        <option selected disabled></option>
                        @foreach($Users as $user)
                            <option value="{{ $user->id }}" @if($user->id == $order->user_id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label w-100">
                        Customer name *
                    </label>
                    <input type="text" class="form-control w-100" id="" name="meta[full_name]"
                        value="{{ $order->getMeta('full_name') }}">
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label w-100">
                        Phone *
                    </label>
                    <input type="text" class="form-control w-100" id="" name="meta[phone]"
                        value="{{ $order->getMeta('phone') }}">
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

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label  w-100">
                        Nationality *
                    </label>

                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                        data-placeholder="Status" data-kt-ecommerce-order-filter="status" name="meta[country_from_id]">
                        <option selected disabled></option>
                        @foreach($countries as $item)
                            <option value="{{ $item->id }}" @if($item->id == $order->getMeta('country_from_id')) selected
                            @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label  w-100">
                        Destination *
                    </label>

                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                        data-placeholder="Status" data-kt-ecommerce-order-filter="status" name="meta[country_to_id]">
                        <option selected disabled></option>
                        @foreach($countries as $item)
                            <option value="{{ $item->id }}" @if($item->id == $order->getMeta('country_to_id')) selected
                            @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-10 fv-row fv-plugins-icon-container">
                    <label for="" class="form-label  w-100">
                        Time arrival *
                    </label>
                    <input type="text" class="form-control w-75 datepicker" name="meta[time_arrival]"
                        value="{{ $order->getMeta('time_arrival') }}">
                </div>

            </div>

        </div>
    </div>

    <br />

    <div class="d-flex justify-content-end">

        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
            <span class="indicator-label">Save Changes</span>
        </button>
    </div>

    </form>

    <!--
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

                    <br />
                    <h3 class="mt-25">
                        {{ __('Total') }}: {{ $order->getTotal() }} {{ $order->getCurrency() }}
                    </h3>

                </div>
            </div>
        </div>
    </div>
    -->


</div>