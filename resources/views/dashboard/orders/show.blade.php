@extends('dashboard.layouts.app')

@section('content')

    <div class="d-flex flex-column gap-7 gap-lg-10">

        @include('dashboard.orders.partials.order-header')

        <div class="tab-content">

            @include('dashboard.orders.partials.order-tab-summary')

            @include('dashboard.orders.partials.order-tab-travellers')

            @include('dashboard.orders.partials.order-tab-certificates')

            @include('dashboard.orders.partials.order-tab-payments')

            @include('dashboard.orders.partials.order-tab-history')

        </div>
    </div>

@endsection