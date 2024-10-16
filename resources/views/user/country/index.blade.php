@extends('user.layouts.app')

@section('content')

<div class="container mb-75 mt-50">
    <div class="row">
        <div class="col-md-7 mr-100">
            <h2>Apply now for your {{ $country->name }} eVisa</h2>

            <!-- Visa Required Information -->
            <div class="alert alert-info mt-4" role="alert">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-card-heading"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        @if( isset($countryFrom) )
                            @if( $direction->visa_req == 1 )
                                <strong>Visa required</strong><br>
                                You need a visa to travel to {{ $country->name }} if you have a passport from {{ $countryFrom->name }}.
                            @else
                                <strong>No visa required</strong><br>
                                You don't need a visa to travel to {{ $country->name }} if you have a passport from {{ $countryFrom->name }}.
                            @endif
                        @else
                            Choose a nationality to see if you need a visa to travel to {{ $country->name }}.
                        @endif
                    </div>
                </div>
            </div>

            @if( $direction->visa_req == 1 )

                <!-- Form Section -->
                <form class="mt-4" method="GET" action="{{ route('user.country.apply', $country->slug) }}">
                    <!-- Nationality -->
                    <div class="mb-4">
                        <label for="nationality" class="form-label">What is your nationality?</label>
                        <select class="form-select" name="nationality" id="nationality" aria-label="Nationality">
                            @foreach($countries as $country)
                                <option></option>
                                <option value="{{ $country->slug }}" data-slug="{{ $country->slug }}"
                                    @if( isset($countryFrom) && $country->slug == $countryFrom->slug ) selected @endif>
                                    {{ $country->name }} - {{ $country->code }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Ensure you select the nationality of the passport you'll be
                            traveling with.</small>
                    </div>

                    <!-- Applying For -->
                    @if( isset( $products ) && count($products) > 0 )
                        <div class="mb-4">
                            <label for="visaType" class="form-label">Applying for</label>
                            <select class="form-select" id="visaType" aria-label="Visa Type" name="product_id">
                                @foreach($products as $product)
                                    <option 
                                        value="{{ $product->id }}"
                                        >
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Start your application</button>
                    </div>
                </form>

            @endif

        </div>

        <!-- Visa Details Section -->
        <div class="col-md-4">

            @if( $direction->visa_req == 1 )

                @if( isset( $products ) && count($products) > 0 )

                    @php $key=0; @endphp
                    @foreach($products as $product)

                        <div 
                            class="custom-card mt-5 product-card" 
                            id="product-card-{{ $product->id }}" @if( $key !=0 ) style="display: none" @endif 
                            >
                            <h6 class="text-uppercase">{{ $product->name }}</h6>
                            <h3>{{ $product->getMeta('valid_for') }} days</h3>
                            <ul class="custom-list mb-4">
                                <li><strong>Valid for: </strong> {{ $product->getMeta('valid_for') }} days</li>
                                <li><strong>Number of entries: </strong> {{ $product->getMeta('entries_number') }}</li>
                                <li><strong>Max stay: </strong> {{ $product->getMeta('max_stay') }} days in total</li>
                            </ul>
                        </div>

                        @php $key++; @endphp

                    @endforeach

                @endif

            @endif

        </div>

    </div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    // Redirect after changin nationality
    jQuery(document).ready(function() {
        jQuery('#nationality').change(function() {
            var selectedNationalitySlug = jQuery(this).find(':selected').data('slug');
            window.location.href = window.location.pathname + "?nationality=" + selectedNationalitySlug;
        });
    });

    // Show product details
    jQuery(document).ready(function() {
        jQuery('#visaType').change(function() {
            var selectedProductId = jQuery(this).find(':selected').val();
            jQuery('.product-card').hide();
            jQuery('#product-card-' + selectedProductId).show();
        });
    });

</script>

<style>
        .custom-card {
            background-color: #e0f7fa;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .custom-card h3 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .custom-list {
            text-align: left;
            list-style: none;
            padding-left: 0;
        }
        .custom-list li {
            display: flex;
            align-items: center;
        }
        .custom-list li::before {
            content: "✔";
            color: #007bff;
            margin-right: 8px;
        }
    </style>

@endsection