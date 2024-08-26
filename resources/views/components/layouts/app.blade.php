<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Author: Kılıç Ali Temiz katemiz@gmail.com">

        <title>{{ $title ?? 'Page Title' }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">


        <link rel="stylesheet" href="{{ asset('/SweetAlert/sweetalert2_min.css') }}">
        <script src="{{ asset('/SweetAlert/sweetalert2.min.js') }}"></script>

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @vite('resources/js/scripts.js')

    </head>

    <body class="bg-[url('{{ asset('/images/HeroPage1.png') }}')] bg-cover bg-center h-screen">

        @include('components.layouts.navbar')
        {{ $slot }}
        @include('components.layouts.footer')

    </body>

</html>
