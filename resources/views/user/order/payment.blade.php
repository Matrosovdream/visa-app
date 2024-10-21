<!-- Errors from flash -->
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


<form class="xb-item--form contact-from w-50" action="{{ route('charge') }}" method="post">

    @csrf

    <input type="hidden" name="user_id" value="1" />
    <input type="hidden" name="order_id" value="{{ $order->id }}" />
    <input type="hidden" name="payment_gateway_id" value="1" />
    <input type="hidden" name="amount" value="1" />
    <input type="hidden" name="currency" value="USD" />
    <input type="hidden" name="quantity" value="{{ $order->getTotal() }}" />
    <input type="hidden" name="description" value="Order Payment #{{ $order->id }}" />


    <div class="row">
        <div class="col-lg-12">
            <div class="xb-item--field">
                <input type="text" name="cc_number" placeholder="Card Number" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="xb-item--field">
                <input type="text" name="expiry_month" placeholder="Month" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="xb-item--field">
                <input type="number" name="expiry_year" placeholder="Year" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="xb-item--field">
                <input type="number" name="cvv" placeholder="CVV" />
            </div>
        </div>
        <div class="col-12">
            <input type="submit" name="submit" value="Pay" class="thm-btn" />
        </div>
    </div>

</form>