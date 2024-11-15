@extends('dashboard.layouts.app')

@section('content')

    <div class="d-flex flex-column gap-7 gap-lg-10">

        @include('dashboard.orders.partials.order-header')

        <div class="tab-content">

            @include('dashboard.orders.partials.order-tab-summary-create')

        </div>
    </div>

@endsection

@section('footer-scripts')

    <script type="text/javascript">
        jQuery(document).ready(function() {

            // Date filter
            jQuery('.datepicker').flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
            });
        });
    </script>

@endsection