@extends('layout.master')

@section('title',__('messages.index_title'))
<!-- @section('title', 'Welcome Page') -->

@section('style')
    @vite(['resources/css/index.css'])
@endsection

@section('main-content')
@php
    $locale = session('locale');

    if ($locale) {
        app()->setLocale($locale);
        config(['app.locale' => $locale]);
    }
    logger('Blade render - app()->getLocale(): ' . app()->getLocale());
@endphp

<main class="welcome">
    <h1>@lang('messages.welcome_first_part') {{session('user_first_name')}} @lang('messages.welcome_second_part')</h1>
    <p>@lang('messages.join_community')</p>
    <a href="{{ url('/register') }}" class="cta-button">@lang('messages.register_now')</a>
</main>
@endsection

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif