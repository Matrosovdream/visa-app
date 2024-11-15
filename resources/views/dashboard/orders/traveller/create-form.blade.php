<div class="card-header">
    <div class="card-title">
        <h2>Traveller create</h2>
    </div>
</div>

<form method="POST"
    action="{{ route('dashboard.orders.traveller.store', ['order' => $order->id]) }}">
    @csrf

    <!-- Categories and fields -->
    <div class="card-body pt-0">
        @foreach(array_chunk($travellerFieldCategories, 2) as $cats) 

            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10 mb-5">

                @foreach($cats as $cat) 

                    <div class="card card-flush py-4 flex-row-fluid">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ $cat['title'] }}</h2>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @foreach($travellerFields[$cat['slug']] as $field_slug => $field)

                                <tr>
                                    <td class="text-start text-gray-800">
                                        @include('dashboard.orders.partials.applicant-field', ['code' => $field_slug, 'field' => $field,])
                                    </td>
                                </tr>

                            @endforeach
                        </div>
                    </div>

                @endforeach

            </div>

        @endforeach

        <div class="d-flex justify-content-end mt-10">
            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                <span class="indicator-label">Save Changes</span>
            </button>
        </div>

    </div>

</form>


