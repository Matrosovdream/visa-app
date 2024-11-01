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