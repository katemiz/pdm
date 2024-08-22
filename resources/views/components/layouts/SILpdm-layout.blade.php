<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Author: Kılıç Ali Temiz katemiz@gmail.com">
        <meta name="theme-color" content="#317EFB"/>

        <title>{{ $title ?? 'Page Title' }}</title>

        {{-- INCLUDES --}}
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

        <link rel="stylesheet" href="{{ asset('/css/bulma.min.css')}}">
        <link rel="stylesheet" href="{{ asset('/SweetAlert/sweetalert2_min.css') }}">
        <script src="{{ asset('/SweetAlert/sweetalert2.min.js') }}"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">

        <script src="{{ asset('/js/js.js') }}"></script>
        <script type="module" src="{{ asset('/js/model-viewer.min.js') }}"></script>
        
    </head>
    <body class='has-background-lighter'>
        @include('components.layouts.pdm-navbar')

        {{ $slot }}

        @include('components.layouts.pdm-footer')
    </body>
</html>
