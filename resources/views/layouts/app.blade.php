<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="Kououdev">
    <meta name="keywords"
        content="kououdev, laravel, bootstrap 5, admin, dashboard, template, responsive, jquery, css, html, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/maps-google.html" />

    <title>Kouboard</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">

        @include('layouts.partials.sidebar')

        <div class="main">
            @include('layouts.partials.navbar')

            <main class="content">
                @yield('content')
            </main>

            @include('layouts.partials.footer')

        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</body>

</html>
