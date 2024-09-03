<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Author: Kılıç Ali Temiz katemiz@gmail.com">
        <meta name="theme-color" content="#317EFB"/>

        <title>{{ config('appconstants.app.name') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>


    <body style="background-image: url('{{ asset('/images/HeroPage1.png') }}');" class="bg-cover bg-center bg-no-repeat">

        @livewire('logware')

    </body>
</html>
