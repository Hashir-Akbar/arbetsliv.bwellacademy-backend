@extends('user-layout-with-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/students.css') }}">
<style>
    .hidden {
        display: none;
    }
    .list-container {
        width: 50%;
    }
    .list-container .profiles-list {
        line-height: normal;
    }
    list-container .profiles-list li .profile-count {
        height: 20px;
    }
</style>
@stop

@section('page-header')
Mina livsstilsplaner
@stop

@section('content')
<div class="list-container">
    <ul class="profiles-list">
        @php
        $count = $profiles->count();
        @endphp
        @foreach ($profiles as $profile)
        <li>
            <a href="{{ url('/statement/' . $profile->id . '/plan') }}">
                @if ($profile->in_progress)
                    <span class="profile-count profile-in-progress">{{ $count-- }}</span>
                @elseif ($profile->completed)
                    <span class="profile-count">{{ $count-- }}</span>
                @else
                    <span class="profile-count profile-almost-done">{{ $count-- }}</span>
                @endif
                <span class="health_profile-date">{{ $profile->date }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@stop