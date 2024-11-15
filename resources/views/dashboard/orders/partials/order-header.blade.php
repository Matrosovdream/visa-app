@php
$tabs = [
    'summary' => ['title' => 'Order Summary', 'slug' => 'summary', 'active' => true],
    'travellers' => ['title' => 'Travellers', 'slug' => 'travellers', 'active' => false],
    'certificates' => ['title' => 'Certificates', 'slug' => 'certificates', 'active' => false],
    'payments' => ['title' => 'Payments', 'slug' => 'payments', 'active' => false],
    //'history' => ['title' => 'Order History', 'slug' => 'history', 'active' => false],
];

if (request()->routeIs('dashboard.orders.traveller.*')) {
    $tabs['travellers']['active'] = true;
    $tabs['summary']['active'] = false;

    // Remove all but the travellers tab
    $tabs = array_filter($tabs, function ($tab) {
        return $tab['slug'] === 'travellers';
    });
}

$edit = request()->routeIs('dashboard.orders.edit') ? true : false;
$create = request()->routeIs('dashboard.orders.create') ? true : false;

if ( $edit || $create ) {
    // Remove all but the travellers tab
    $tabs = array_filter($tabs, function ($tab) {
        return $tab['slug'] === 'summary';
    });
}
@endphp


<div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">

        @foreach($tabs as $tab)
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 {{ $tab['active'] ? 'active' : '' }}" data-bs-toggle="tab"
                    href="#kt_ecommerce_sales_order_{{ $tab['slug'] }}">{{ $tab['title'] }}</a>
            </li>
        @endforeach

    </ul>

    @if(!$edit && !$create)
        <a href="{{ route('dashboard.orders.edit', $order->id) }}" class="btn btn-success btn-sm me-lg-n7">Edit Order</a>
        <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary btn-sm">Add New Order</a>
    @endif

</div>