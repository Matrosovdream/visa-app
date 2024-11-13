@foreach($fields as $code => $field)

    @if($field['type'] == 'text')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            <input type="text" class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]"
                value="{{ $field['value'] }}">
            @if( isset($field['icon']) ) 
                <span class="icon">
                    <img src="{{ asset('/user/assets/img/icon/'.$field['icon']) }}" alt="">
                </span>
            @endif
        </div>

    @endif

    @if($field['type'] == 'textarea')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            <textarea class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]">{{ $field['value'] }}</textarea>
            @if( isset($field['icon']) ) 
                <span class="icon">
                    <img src="{{ asset('/user/assets/img/icon/'.$field['icon']) }}" alt="">
                </span>
            @endif
        </div>

    @endif

    @if($field['type'] == 'date')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            <input type="text" class="form-control w-75 datepicker" id="field-{{ $code }}" name="fields[{{ $code }}]" value="{{ $field['value'] }}">
            @if( isset($field['icon']) ) 
                <span class="icon">
                    <img src="{{ asset('/user/assets/img/icon/'.$field['icon']) }}" alt="">
                </span>
            @endif
        </div>

    @endif

    @if($field['type'] == 'select')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            <select class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]">
                <option selected disabled></option>
                @foreach($field['options'] as $option)
                    <option value="{{ $option['value'] }}" @if( $option['value'] == $field['value'] ) selected @endif>
                        {{ $option['title'] }}
                    </option>
                @endforeach
            </select>
        </div>

    @endif

    @if($field['type'] == 'file')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            @if( isset($field['value']) )
                <a href="{{ Storage::url($field['value']->path) }}" target="_blank">
                    {{ __('Download') }}
                </a>
            @endif    

            <input type="file" class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]">
        </div>

    @endif

    @if($field['type'] == 'radio')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            @foreach($field['options'] as $option)
                <div class="form-check">
                    <label class="form-check" for="field-{{ $code }}-{{ $option['value'] }}">
                        <input class="form-check" type="radio" value="{{ $option['value'] }}"
                            id="field-{{ $code }}-{{ $option['value'] }}" name="fields[{{ $code }}]"
                            @if( $option['value'] == $field['value'] ) checked @endif
                            >
                        {{ $option['title'] }}
                    </label>
                </div>
            @endforeach
        </div>

    @endif

    @if($field['type'] == 'checkbox')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label">
                {{ $field['title'] }} {{ $field['required'] ? '*' : '' }}
            </label>
            <div class="form-check">
                <input class="form-check w-75" type="checkbox" id="field-{{ $code }}"
                    @if( $field['value'] == 1 ) checked @endif
                    name="fields[{{ $code }}]">
            </div>
        </div>

    @endif

@endforeach