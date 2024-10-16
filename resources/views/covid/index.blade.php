<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"></noscript>

    <!-- Font Awesome -->
    <link rel="preload" href="https://unpkg.com/@fortawesome/fontawesome-free@6.0.0-beta2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    {{-- <noscript><link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.0.0-beta2/css/all.min.css"></noscript> --}}

    <link href="/frontend/css/style.css" rel="stylesheet">
    <title>@yield('title', 'Vaccination')</title>
    {{-- <title>ewrqw</title> --}}
    @yield('styles')

   
</head>

<body>

@include('covid.inc.message')

@yield('content')

@include('covid.inc.footer')

<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')

</body>
</html>
