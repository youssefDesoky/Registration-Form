@extends('layout.master')

@section('title', 'Welcome Page')

@section('style')
    @vite(['resources/css/index.css'])
@endsection

@section('main-content')
<main class="welcome">
    <h1>Welcome to Our Registration Portal</h1>
    <p>Join our community and experience the best service with secure and easy registration. Get started by creating your account today!</p>
    <a href="{{ url('/register') }}" class="cta-button">Register Now</a>
</main>
@endsection