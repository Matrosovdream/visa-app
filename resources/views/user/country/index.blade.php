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
                <form class="mt-4">
                    <!-- Nationality -->
                    <div class="mb-4">
                        <label for="nationality" class="form-label">What is your nationality?</label>
                        <select class="form-select" id="nationality" aria-label="Nationality">
                            @foreach($countries as $country)
                                <option></option>
                                <option value="{{ $country->id }}" 
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
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            Egypt eVisa
                        </h5>
                        <ul class="list-unstyled">
                            <li><strong>Valid for:</strong> 90 days after issued</li>
                            <li><strong>Number of entries:</strong> Single entry</li>
                            <li><strong>Max stay:</strong> 30 days in total</li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
</div>


@endsection