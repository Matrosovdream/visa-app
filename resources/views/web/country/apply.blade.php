@extends('web.layouts.app')

@section('content')


<div class="container mt-2">

    <div class="row mb-10">
        <h1 class="">
            <span>{{ $product->name }} • {{ $product->getMeta('entries_number') }} entry </span>
        </h1>
    </div>

    <div class="row">

        <div class="step-indicator">
            <div id="step-indicator-1" class="active">1 | Trip details</div>
            <div id="step-indicator-2">2 | Your info</div>
            <div id="step-indicator-3">3 | Checkout</div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-8">
            <form 
                id="multiStepForm" 
                class="xb-item--form contact-from" 
                method="POST" 
                action="{{ route('web.order.create-apply') }}"
                >

                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="country_to_id" value="{{ $country->id }}">
                <input type="hidden" name="country_to_code" value="{{ $country->code }}">
                <input type="hidden" name="country_from_id" value="{{ $countryFrom->id }}">
                <input type="hidden" name="country_from_code" value="{{ $countryFrom->code }}">

                <input type="hidden" name="product_price" value="{{ $totalPrice }}">
                <input type="hidden" name="product_extras_price" value="{{ $extrasPrice }}">

                <input type="hidden" name="currency" value="{{ $currency }}">
                <input type="hidden" name="quantity" value="1">

                <div id="step-1" class="form-step form-step-active">
                    <h3>Trip details</h3>
                    <div class="mb-3 xb-item--field">
                        <label for="arrivalDate" class="form-label w-100">When do you arrive in {{ $country->name }}?</label>
                        <input type="date" class="form-control w-75" name="time_arrival" id="arrivalDate" required>
                    </div>

                    <div class="mb-3 xb-item--field">
                        <label for="full_name" class="form-label  w-100">Your full name</label>
                        <input type="text" class="form-control w-75" id="full_name" name="full_name" required>
                    </div>

                    <div class="mb-3 xb-item--field">
                        <label for="phone" class="form-label  w-100">Phone number</label>
                        <input type="tel" class="form-control w-75" id="phone" name="phone" required>
                    </div>
                    
                    <div class="mb-3 xb-item--field">
                        <label for="email" class="form-label  w-100">Email address</label>
                        <input type="email" class="form-control w-75" id="email" name="email" placeholder="example@mail.com" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="next-1">Next</button>
                </div>

                <div id="step-2" class="form-step form-step-active1">
                    
                    <div class="card-traveler mt-25">

                        <h3>Traveler #1</h3>

                        <div class="mb-3 xb-item--field">
                            <label class="form-label w-100">First and middle name</label>
                            <input type="text" name="travelers[name][]" class="form-control w-75" required>
                        </div>

                        <div class="mb-3 xb-item--field">
                            <label class="form-label w-100">Last name</label>
                            <input type="text" name="travelers[lastname][]" class="form-control w-75" required>
                        </div>

                        <div class="mb-3 xb-item--field">
                            <label for="arrivalDate" class="form-label w-100">Birthday</label>
                            <input type="date" name="travelers[birthday][]" class="form-control w-75" id="arrivalDate" required>
                        </div>

                        <div class="mb-3 xb-item--field">
                            <label for="arrivalDate" class="form-label w-100">Passport number</label>
                            <input type="text" name="travelers[passport][]" class="form-control w-75" id="arrivalDate" required>
                        </div>

                        <div class="row">
                            <label for="arrivalDate" class="form-label w-100">Passport expiration date</label>
                            <div class="col-lg-3">
                                <div class="xb-item--field">
                                    <!-- Select day of the month -->
                                    <select class="nice-select w-100" id="arrivalAirport" name="travelers[passport-expiration-day][]" required>
                                        <option value="" selected>Day</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="xb-item--field">
                                    <!-- Select Month -->
                                    <select class="nice-select w-100" id="arrivalAirport" name="travelers[passport-expiration-month][]" required>
                                        <option value="" selected>Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>    
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="xb-item--field">
                                    <!-- Select Year -->
                                    <select class="nice-select w-100" id="arrivalAirport" name="travelers[passport-expiration-year][]" required>
                                        <option value="" selected>Year</option>
                                        @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="mb-3 xb-item--field">
                        <button type="button" id="add_traveler" class="btn btn-primary w-100 mt-3">Add traveler</button>
                    </div>

                    <br/>

                    <button type="button" class="btn btn-secondary" id="prev-2">Previous</button>
                    <button type="button" class="btn btn-primary" id="next-2">Next</button>

                </div>

                <div id="step-3" class="form-step form-step form-step-active1">
                    <h3>Choose your processing time</h3>

                    <ul class="list-group">
                        @foreach( $product->offers as $offer )
                            <li class="list-group-item">
                                <div class="form-check
                                    @if( $loop->first ) active @endif">

                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        name="offer_id" 
                                        id="offer-{{ $offer->id }}" 
                                        value="{{ $offer->id }}" 
                                        data-price="{{ $offer->price }}"
                                        @if( $loop->first ) checked @endif
                                        >
                                    
                                    <label class="form-check label" for="offer-{{ $offer->id }}">
                                        <h5>{{ $offer->name }}</h5>
                                        <p>{{ $offer->description }}</p>
                                        <p>{{ $offer->price }} {{ $currency }}</p>
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>    

                    <br/>
                    <button type="button" class="btn btn-secondary" id="prev-3">Previous</button>

                </div>

                <div id="step-3" class="form-step">
                    <h3>Checkout</h3>
                    <p>Confirm your details and proceed to checkout.</p>
                    <button type="button" class="btn btn-secondary" id="prev-3">Previous</button>
                    <button type="submit" class="btn btn-success">Save and Continue</button>
                </div>

            </form>
        </div>

        <!-- Sidebar Section -->
        <div class="col-md-4">
            <div class="sidebar">

                <table class="table summary-table">
                    <tbody>
                        <tr>
                            <td>
                                <h5>{{ $product->name }}</h5>
                            </td>
                            <td><p id="traveler-count">1 traveler</p></td>
                        </tr>

                        @foreach( $product->extras as $extra ) 
                            <tr>
                                <td>+ {{ $extra->name }}</td>
                                <td>
                                    <span id="extras-price-span">
                                        {{ $extra->price }} 
                                        {{ $currency }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td>+ Service fees</td>
                            <td>
                                <span id="price-span">{{ $product->offers->first()->price }} {{ $currency }}</span>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <button type="button" class="btn btn-primary w-100 mt-3 pay-button">Pay order</button>

            </div>
        </div>
    </div>
</div>

<br/>
<br/>



<script>
    $(document).ready(function () {

        calcTotals();

        // Step navigation logic
        function updateStepIndicator(step) {
            $('.step-indicator div').removeClass('active');
            $('#step-indicator-' + step).addClass('active');
            if (step == 3) {
                $('.pay-button').show();
            } else {
                $('.pay-button').hide();
            }
        }

        $('#next-1').click(function () {
            if( validate_step1() ) {
                $('#step-1').removeClass('form-step-active');
                $('#step-2').addClass('form-step-active');
                updateStepIndicator(2);
            }
        });

        $('#next-2').click(function () {
            if( validate_step2() ) {
                $('#step-2').removeClass('form-step-active');
                $('#step-3').addClass('form-step-active');
                updateStepIndicator(3);
            }
        });

        $('#prev-2').click(function () {
            $('#step-2').removeClass('form-step-active');
            $('#step-1').addClass('form-step-active');
            updateStepIndicator(1);
        });

        $('#prev-3').click(function () {
            $('#step-3').removeClass('form-step-active');
            $('#step-2').addClass('form-step-active');
            updateStepIndicator(2);
        });

        // Add traveler logic
        var travelerCount = 1;
        $('#add_traveler').click(function () {

            // Clone the element and append it to the form
            var traveler = $('.card-traveler').first().clone();
            travelerCount++;
            traveler.find('h3').text('Traveler #' + travelerCount);
            $('.card-traveler').last().after(traveler);

            // clean the fields
            traveler.find('input').val('');

            // Update traveler count
            $('#traveler-count').text(travelerCount + ' travelers');
            $('input[name="quantity"]').val(travelerCount);

            // Update price with currency
            calcTotals();
            
        });

        // Offer selection logic
        $('input[name="offer_id"]').change(function () {
            var price = $(this).data('price');
            $('input[name="product_price"]').val(price);
            calcTotals();
        });

        // Submit form
        $('.pay-button').click(function () {
            $('#multiStepForm').submit();
        });

    });

    function validate_step1() {
        
        // Manual validation
        var arrivalDate = $('#arrivalDate').val();
        var fullName = $('#full_name').val();
        var phone = $('#phone').val();
        var email = $('#email').val();

        var isValid = true;

        $('label.error').remove();

        // Check all fields and if not valid, show error label.error after the fields
        if (arrivalDate == '') {
            $('#arrivalDate').after('<label class="error">This field is required</label>');
            isValid = false;
        } 

        if (fullName == '') {
            $('#full_name').after('<label class="error">This field is required</label>');
            isValid = false;
        } 

        if (phone == '') {
            $('#phone').after('<label class="error">This field is required</label>');
            isValid = false;
        }

        if (email == '' || !check_email(email)) {
            $('#email').after('<label class="error">Check email value</label>');
            isValid = false;
        }

        return isValid;

    }

    function validate_step2() {

        // Check all traveller fields
        var isValid = true;

        $('label.error').remove();

        // Check all fields and if not valid, show error label.error after the fields
        $('input[name^="travelers[name]"]').each(function() {
            if ($(this).val() == '') {
                $(this).after('<label class="error">This field is required</label>');
                isValid = false;
            }
        });

        $('input[name^="travelers[lastname]"]').each(function() {
            if ($(this).val() == '') {
                $(this).after('<label class="error">This field is required</label>');
                isValid = false;
            }
        });

        $('input[name^="travelers[birthday]"]').each(function() {
            if ($(this).val() == '') {
                $(this).after('<label class="error">This field is required</label>');
                isValid = false;
            }
        });

        $('input[name^="travelers[passport]"]').each(function() {
            if ($(this).val() == '') {
                $(this).after('<label class="error">This field is required</label>');
                isValid = false;
            }
        });

        return isValid;

    }

    function check_email(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    function calcTotals() {

        var price = parseFloat($('input[name="product_price"]').val());
        var extras_price = parseFloat($('input[name="product_extras_price"]').val());
        var currency = '{{ $currency }}';
        var travelerCount = $('input[name="quantity"]').val();

        // Update price with currency
        $('#price-span').text(price * travelerCount + ' ' + currency);
        $('#extras-price-span').text(extras_price * travelerCount + ' ' + currency);

    }

</script>



<style>

    label.error {
        color: red;
        font-size: 14px;
    }

    .pay-button {
        display: none;
    }

    .summary-table {
        --tw-bg-opacity: 1;
        background-color: rgb(248 249 249 / var(--tw-bg-opacity));
    }

    .step-indicator {
        display: flex;
        justify-content: space-around;
        margin-bottom: 30px;
        padding: 10px;
    }

    .step-indicator div {
        text-align: center;
        width: 30%;
        padding: 5px 0;
        border: 1px solid #d4d4d4;
        border-radius: 30px;
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: bold;
    }

    .step-indicator .active {
        background-color: #0d6efd;
        color: white;
        border: 1px solid #0d6efd;
    }

    /* Form Styling */
    .form-step {
        display: none;
    }

    .form-step-active {
        display: block;
    }

    .form-label {
        font-weight: 500;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004080;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    h3 {
        margin-bottom: 20px;
    }
</style>

@endsection