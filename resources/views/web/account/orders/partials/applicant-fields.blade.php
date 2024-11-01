@foreach($fields as $code => $field)

    @if($field['type'] == 'text')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }}
            </label>
            <input type="text" class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]"
                value="{{ $field['value'] }}">
        </div>

    @endif

    @if($field['type'] == 'textarea')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }}
            </label>
            <textarea class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]"></textarea>
        </div>

    @endif

    @if($field['type'] == 'date')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }}
            </label>
            <input type="date" class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]" value="">
        </div>

    @endif

    @if($field['type'] == 'select')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }}
            </label>
            <select class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]">
                <option selected disabled></option>
                @foreach($field['options'] as $option)
                    <option value="{{ $option['value'] }}">
                        {{ $option['title'] }}
                    </option>
                @endforeach
            </select>
        </div>

    @endif

    @if($field['type'] == 'file')

        <div class="mb-3 xb-item--field">
            <label for="field-{{ $code }}" class="form-label  w-100">
                {{ $field['title'] }}
            </label>
            @if( isset($field['value']) )
                <a href="{{ Storage::url($field['value']->path) }}" target="_blank">
                    {{ __('Download') }}
                </a>
            @endif    

            <input type="file" class="form-control w-75" id="field-{{ $code }}" name="fields[{{ $code }}]">
        </div>

    @endif

@endforeach