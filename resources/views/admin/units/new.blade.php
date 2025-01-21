@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
Nytt företag
@else
Ny skola
@endif
@stop

@section('content')
    {{ Form::open(array('action' => array('UnitController@postNew'), 'class' => 'info-form new-unit-form')) }}

        <div>
            <label for="name">Namn *</label><br>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
            <input name="name" id="name" type="text" value="{{ Request::old('name') }}">
        </div>

        @if (config('fms.type') == 'work')
            <div>
                <label for="business_category">{{ __('units.business-category') }}</label><br>
                <select name="business_category" id="business_category">
                    <option value="">-- Välj --</option>
                    @foreach($businessCategories as $businessCategory)
                        <option value="{{ $businessCategory->id }}" @selected(old('business_category') == $businessCategory->id)>{{ $businessCategory->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @if (config('fms.type') == 'school')
            <div>
                <label for="school_type">Skolform *</label><br>
                @error('school_type')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select name="school_type" id="school_type">
                    <option value="" selected hidden>-- Välj --</option>
                    @if (Request::old('school_type') == 'primary')
                        <option value="primary" selected="selected">Grundskola</option>
                    @else
                        <option value="primary">Grundskola</option>
                    @endif
                    @if (Request::old('school_type') == 'secondary')
                        <option value="secondary" selected="selected">Gymnasium</option>
                    @else
                        <option value="secondary">Gymnasium</option>
                    @endif
                </select>
            </div>
        @endif

        <div>
            <label for="country">Land *</label><br>
            @error('country')
                <div class="error">{{ $message }}</div>
            @enderror
            <select name="country" id="country">
                <option value="" selected hidden>-- Välj --</option>
                @foreach ($countries as $country)
                    <?php $selected = $country->id == Request::old('country') ? 'selected="selected"' : ''; ?>
                    <option value="{{ $country->id }}" {{ $selected }}>{{ __($country->label) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="county">Län *</label><br>
            @error('county')
                <div class="error">{{ $message }}</div>
            @enderror
            <select name="county" id="county">
                <option value="" selected hidden>-- Välj --</option>
                @foreach ($counties as $county)
                    @if ($county->country_id == Request::old('country'))
                        <?php $selected = $county->id == Request::old('county') ? 'selected="selected"' : ''; ?>
                        <option value="{{ $county->id }}" {{ $selected }}>{{ __($county->label) }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div>
            <label for="email">Epostadress</label><br>
            <input name="email" id="email" type="text" value="{{ Request::old('email') }}">
        </div>

        <div>
            <label for="phone">Telefonnummer</label><br>
            <input name="phone" id="phone" type="text" value="{{ Request::old('phone') }}">
        </div>

        @if ($errors->has('first_name'))
        <span class="errors">{{ $errors->first('first_name') }}</span>
        @endif
        <label for="first_name">Admin Förnamn *</label>
        <input type="text" name="first_name" value="{{ Request::old('first_name') }}" required><br>

        @if ($errors->has('last_name'))
        <span>{{ $errors->first('last_name') }}</span>
        @endif
        <label for="last_name">Admin Efternamn *</label>
        <input type="text" name="last_name" value="{{ Request::old('last_name') }}" required><br>

        @if ($errors->has('email'))
        <span>{{ $errors->first('email') }}</span>
        @endif
        <label for="email">Admin Emailadress *</label>
        <input type="text" name="email" value="{{ Request::old('email') }}" required><br>

        <div>
            {{ Form::submit('Skapa', array('class' => 'btn')) }}

            <a class="back-link" href="{{ url('/admin/units/') }}">Avbryt</a>
        </div>

    {{ Form::close() }}

    <script>
        $("#country").change(function() {
            var id = $(this).val();
            var root = $("#county");
            var counties = JSON.parse('<?php echo $counties_json; ?>');

            root.empty();
            root.append('<option value="" selected hidden>-- Välj --</option>');

            for (county of counties) {
                if (county.country_id != id) {
                    continue;
                }
                var opt = $(document.createElement('option'));
                opt.val(county.id);
                opt.text(county.label);
                root.append(opt);
            }
        });
    </script>
@stop