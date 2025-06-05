<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/header.css', 'resources/css/footer.css'])
    @yield('style')
    
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
