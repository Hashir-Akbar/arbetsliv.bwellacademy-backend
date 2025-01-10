@if ($editable)
<select name="{{ $name }}" id="{{ $name }}">
@else
<select name="{{ $name }}" id="{{ $name }}" disabled="disabled">
@endif
    <option value="0"></option>
    @for ($i = 50; $i <= 275; $i += 25)
        @if ($i === intval($value))
            <option value="{{ $i }}" selected="selected">{{ $i }}</option>
        @else
            <option value="{{ $i }}">{{ $i }}</option>
        @endif
    @endfor
</select>