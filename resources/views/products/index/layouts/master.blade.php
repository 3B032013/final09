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

    </head>
    <body>
        @include('layouts.partials.navigation')
        <section id="location">
            @yield('content')
        </section>
        @include('layouts.partials.footer')
    </body>
<html>
