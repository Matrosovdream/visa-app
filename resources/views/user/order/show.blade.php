@extends('user.layouts.app')

@section('content')

    <div class="container mt-30 mb-30">
        <div class="row">
            <div class="col-md-12">
                <h1>Order Details #{{ $order->id }}</h1>
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
                        @foreach($order->products as $product)
                        <tr>
                            <td>{{ $product->product->name }}</td>
                            <td class="text-center">{{ $product->quantity }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Total: {{ $order->getTotal() }}$</h3>

                <!-- Pay with Authorize.net -->
                

            </div>
        </div>
    </div>

@endsection