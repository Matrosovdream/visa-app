@extends('web.layouts.app')

@section('content')

<div class="container my-5">

    <h2 class="mb-25">
        {{ __('Order') }} #{{ $order->id }} - {{ $order->getProduct()->name }}
    </h2>

    <hr/>

    <!-- Order Summary -->
    <h4 class="mb-15">{{ __('Order Summary') }}</h4>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-35">

    
        <div class="col active-status-block">
            <div class="card shadow-sm h-100">
                <div class="card-body">

                    @if( $order->getProgress() == 1 )
                        <h5 class="card-title card-title-small mt-3 alert alert-danger text-center">
                            {{ __('Actions needed') }}
                        </h5>
                    @else
                        <h5 class="card-title card-title-small mt-3 alert alert-success text-center">
                            {{ __('Form is completed') }}
                        </h5>
                    @endif

                    <p>{{ $order->createAt }}</p>

                    @if( $order->getProgress() == 1 )
                        <p class="card-text">{{ __('We need more information from you') }}</p>
                    @elseif( $order->getProgress() == 2 )
                        <p class="card-text">{{ __('We are preparing your order') }}</p>
                    @elseif( $order->getProgress() == 3 )
                        <p class="card-text">{{ __('Your order is completed') }}</p>
                    @endif

                </div>
                <div class="card-footer bg-white mb-10 mt-10 border-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('web.account.order.trip', $order->id) }}" class="text-decoration-none">
                        @if( $order->getProgress() == 1 )
                            {{ __('Complete form now') }}
                        @else
                            {{ __('View details') }}
                        @endif
                    </a>
                    <a href="{{ route('web.account.order.trip', $order->id) }}" class="btn-arrow">➔</a>
                </div>
            </div>
        </div>

        <div class="col @if( $order->getProgress() == 1 ) non-active-status-block @endif">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mt-3 text-center mb-30">
                        {{ __('Waiting on Government') }}
                    </h5>
                    <p>{{ $order->createAt }}</p>
                    <p class="card-text">
                        {{ __('We are currently waiting for the Government to get back to us on the result of your application') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col @if( $order->getProgress() == 2 || $order->getProgress() == 1 ) non-active-status-block @endif">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mt-3 text-center mb-30">
                        {{ __('Order closed') }}
                    </h5>
                    <p>{{ $order->createAt }}</p>
                    <p class="card-text">
                        {{ __('Congratulations! Your document is ready for download!') }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Applicants -->
    <h4 class="mb-15">{{ __('Applicants') }}</h4>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-35">

        @foreach( $order->travellers as $traveller )

            <div class="col active-status-block">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="mb-10">
                            {{ $traveller->name }} {{ $traveller->lastname }}
                        </h5>

                        @if( !$traveller->isCompletedForm() )
                            <p>We need you to complete the following questions in order to move forward with your Egypt eVisa.</p>
                        @endif
                        
                    </div>
                    <div class="card-footer bg-white mb-10 mt-10 border-0 d-flex justify-content-between align-items-center">
                        <a href="{{ route('web.account.order.applicant.documents', ['order_id' => $order->id, 'applicant_id' => $traveller->id]) }}" class="text-decoration-none">
                            @if( !$traveller->isCompletedForm() )
                                {{ __('Complete form now') }}
                            @else
                                {{ __('View details') }}
                            @endif
                        </a>
                        <a href="{{ route('web.account.order.applicant.documents', ['order_id' => $order->id, 'applicant_id' => $traveller->id]) }}" class="btn-arrow">➔</a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    <div class="row">

    <!-- Completed Documents -->
    <div class="d-flex justify-content-between align-items-center my-3 block-border">
        <div>
            <h5>{{ __('Completed Documents') }}</h5>
            <p>{{ __('View all applicants completed documents') }}</p>
        </div>
        <button class="btn btn-outline-primary">
            {{ __('View documents') }}
        </button>
    </div>

    <!-- Add-on Services -->
    <div class="d-flex justify-content-between align-items-center my-3 block-border">
        <div>
            <h5>{{ __('Add-on services') }}</h5>
            <p>{{ __('Upgrade your travel experience with our add-on services.') }}</p>
        </div>
        <button class="btn btn-outline-primary">
            {{ __('Choose add-ons') }}
        </button>
    </div>

    <!-- Order Details -->
    <div class="order-details mt-25">
        <div class="d-flex justify-content-between mb-40">
            <h4>{{ __('Order Details') }}</h4>
            <a href="#" class="text-primary">{{ __('View Invoice') }}</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ __('Government fees') }}</td>
                    <td>
                        {{ $order->getTotal() }} {{ $order->getCurrency() }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ $order->getOffer()->name }}
                    </td>
                    <td>
                        {{ $order->getTotal() }} {{ $order->getCurrency() }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
        /* Additional custom styles */
        .progress-bar-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }
        .applicant-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: start;
        }
        .btn-complete {
            background-color: #28a745;
            color: white;
        }
        .order-summary, .order-details {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-details {
            background-color: rgb(248 249 249);
        }
        .order-details table th,
        .order-details table td {
            background-color: rgb(248 249 249);
        }
        .block-border {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
        }
        .card-body {
        background-color: rgb(248 249 249);
    }
    .card-status {
        background-color: #d1ecf1;
        color: #0c5460;
        border-radius: 10px;
        padding: 4px 8px 2px 8px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .card-progress {
        background-color: #e9ecef;
        border-radius: 50%;
        padding: 5px;
        font-size: 0.8rem;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-country img {
        width: 20px;
        margin-right: 5px;
    }

    .btn-arrow {
        background: linear-gradient(90deg, #00d7b0, #00e65b);
        color: white;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border: none;
    }
    .card-text {
        font-size: 15px;
    }
    .non-active-status-block {
        opacity: 0.5;
    }
    .active-status-block {
        opacity: 1;
    }
    </style>


@endsection