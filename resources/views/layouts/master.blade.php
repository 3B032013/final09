<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
{{--        <link rel="stylesheet" href="{{asset('css/styles.css')}}">--}}
{{--        <link rel="stylesheet" href="{{asset('css/style.css')}}">--}}

        <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="{{asset('css/homepage-styles.css')}}" rel="stylesheet" />

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.partials.navigation')
        <section id="location">
            @yield('content')
        </section>

{{--        <!-- Bootstrap core JS-->--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>--}}
{{--        <!-- Core theme JS-->--}}
{{--        <script src="{{asset('js/scripts.js')}}"></script>--}}

        @include('layouts.partials.footer')
    </body>
<html>
