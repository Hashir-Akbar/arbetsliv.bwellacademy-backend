@if ($editable)
<select name="{{ $name }}" id="{{ $name }}">
@else
<select name="{{ $name }}" id="{{ $name }}" disabled="disabled">
@endif
    <option value=""></option>
    @for ($i = 6; $i <= 20; $i++)
        @if ($i == intval($value))
            <option value="{{ $i }}" selected="selected">{{ $i }}</option>
        @else
            <option value="{{ $i }}">{{ $i }}</option>
        @endif
    @endfor
</select>