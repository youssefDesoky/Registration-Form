<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oi&display=swap" rel="stylesheet">
    
    <script>
        window.Laravel={
            locale: "{{ app()->getLocale() }}",
        };
    </script>
    
    @vite(['resources/css/header.css', 'resources/css/footer.css'])
    @yield('style')
    @if(app()->getLocale() == 'ar')
        @vite(['resources/css/rtl.css'])
    @endif

    
    <title>@yield('title', 'Unknown Page')</title>
</head>
<body>
    @include('layout.header')

    <div class="container">
        @yield('main-content')
    </div>

    @include('layout.footer')
    
    @vite(['resources/js/header.js', 'resources/js/footer.js'])
    @yield('script')
</body>
</html>
