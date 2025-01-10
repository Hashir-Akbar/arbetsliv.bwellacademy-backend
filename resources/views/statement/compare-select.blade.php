@extends('statement.base')

@section('page-title')
{{ __('statement.compare-title') }}
@stop

@section('tab-contents')
<section>
    <h2>Välj profil att jämföra med</h2>

    @php
    $count = $profiles->count();
    @endphp
    <ul class="profiles-list">
        @foreach ($profiles as $profile2)
        @php
        if ($profile2->id == $profile->id) {
            $count--;
            continue;
        }
        @endphp
        <li>
            <a href="{{ url('/statement/' . $profile->id . '/compare/' . $profile2->id) }}">
                <span class="profile-count">{{ $count-- }}</span>
                {{ $profile2->date }}
            </a>
        </li>
        @endforeach
    </ul>

</section>
@stop