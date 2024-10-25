@extends('web.layouts.app')

@section('content')

    <div class="container mt-30 mb-30">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-20">Order Details #{{ $order->id }}</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th class="text-center">Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->cartProducts as $product)
                            <tr>
                                <td>{{ $product->product->name }}</td>
                                <td class="text-center">{{ $product->quantity }}</td>
                                <td>{{ $product->price }} {{ $order->getCurrency() }}</td>
                                <td>{{ $product->total }} {{ $order->getCurrency() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Total: {{ $order->getTotal() }} {{ $order->getCurrency() }}</h3>

            </div>
        </div>

        <div class="row mt-50">

            <h1 class="mb-20">Payment</h1>

            @include('web.order.payment')

        </div>

    </div>

@endsection