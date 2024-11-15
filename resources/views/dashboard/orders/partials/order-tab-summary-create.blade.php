<div class="tab-pane fade @if (!request()->routeIs('dashboard.orders.traveller.*')) active show @endif"
    id="kt_ecommerce_sales_order_summary" role="tab-panel">

    <form method="POST" action="{{ route('dashboard.orders.store') }}">
        @csrf

        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <div class="card card-flush py-4 flex-row-fluid">

                <div class="card-header">
                    <div class="card-title">
                        <h2>Order Create</h2>
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
                                <option value="{{ $status->id }}" @if($status->slug == old('slug')) selected @endif>
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
                                <option value="{{ $item->code }}" @if($item->code == old('currency')) selected @endif>
                                    {{ $item->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label for="" class="form-label  w-100">
                            Product *
                        </label>

                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Status" data-kt-ecommerce-order-filter="status" name="product">
                            <option selected disabled></option>
                            @foreach($products as $item)
                                @foreach( $item->offers as $offer)
                                    <option value="{{ $item->id }}|{{ $offer->id }}" @if($offer->id == old('product')) selected @endif>
                                     {{ $item->name }} - {{ $offer->name }}
                                    </option>
                                @endforeach
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
                                <option value="{{ $user->id }}" @if($user->id == old('fields.user_id')) selected @endif>
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
                            value="{{ old('meta.full_name') }}">
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <label for="" class="form-label w-100">
                            Phone *
                        </label>
                        <input type="text" class="form-control w-100" id="" name="meta[phone]"
                            value="{{ old('meta.phone') }}">
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
                            data-placeholder="Status" data-kt-ecommerce-order-filter="status"
                            name="meta[country_from_id]">
                            <option selected disabled></option>
                            @foreach($countries as $item)
                                <option value="{{ $item->id }}" @if($item->id == old('meta.country_from_id')) selected @endif>
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
                            data-placeholder="Status" data-kt-ecommerce-order-filter="status"
                            name="meta[country_to_id]">
                            <option selected disabled></option>
                            @foreach($countries as $item)
                                <option value="{{ $item->id }}" @if($item->id == old('meta.country_to_id')) selected @endif>
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
                            value="{{ old('meta.time_arrival') }}">
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

</div>