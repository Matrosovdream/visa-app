<div class="tab-pane fade @if (request()->routeIs('dashboard.orders.traveller.*')) active show @endif"
    id="kt_ecommerce_sales_order_travellers" role="tab-panel">
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="card card-flush py-4 flex-row-fluid">

            @if (request()->routeIs('dashboard.orders.traveller.show'))

                <div class="card-body pt-0 pb-0">
                    <a href="{{ route('dashboard.orders.show', ['order_id' => $order->id]) }}"
                        class="btn btn-success btn-sm me-lg-n7">
                        Back to order
                    </a>
                </div>

                <div class="card-header">
                    <div class="card-title">
                        <h2>Traveller #{{ $traveller['id'] }}</h2>
                    </div>
                </div>

                <!-- Documents -->
                <div class="table-responsive">
                    @include('dashboard.orders.partials.traveller-documents-table')
                </div>
                <br/>
                <!-- Categories and fields -->
                <div class="card-body pt-0">
                    @include('dashboard.orders.partials.traveller-categories-table')
                </div>

            @elseif (request()->routeIs('dashboard.orders.traveller.edit'))

                <div class="card-body pt-0 pb-0">
                    <a href="{{ route('dashboard.orders.show', ['order_id' => $order->id]) }}"
                        class="btn btn-success btn-sm me-lg-n7">
                        Back to order
                    </a>
                </div>

                <div class="card-header">
                    <div class="card-title">
                        <h2>Traveller #{{ $traveller['id'] }} Edit</h2>
                    </div>
                </div>

                <!-- Documents -->
                <div class="table-responsive">
                    @include('dashboard.orders.partials.traveller-documents-table')
                </div>
                <br/>

                @include('dashboard.orders.traveller.edit-form')

            @elseif (request()->routeIs('dashboard.orders.traveller.create'))

                <div class="card-body pt-0 pb-0">
                    <a href="{{ route('dashboard.orders.show', ['order_id' => $order->id]) }}"
                        class="btn btn-success btn-sm me-lg-n7">
                        Back to order
                    </a>
                </div>

                @include('dashboard.orders.traveller.create-form')

            @else

                <div class="card-header">
                    <div class="card-title">
                        <h2>Travellers</h2>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        @include('dashboard.orders.partials.travellers-table')
                    </div>

                    <div class="form-group mt-5">
                        <a href="{{ route('dashboard.orders.traveller.create', $order->id) }}">
                            <button type="button" class="btn btn-sm btn-light-primary">
                                <i class="ki-duotone ki-plus fs-2"></i>
                                Add traveller
                            </button>
                        </a>
                    </div>

                </div>

            @endif

            </hr>
        </div>
    </div>
</div>