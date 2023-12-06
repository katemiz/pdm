<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Author: Kılıç Ali Temiz katemiz@gmail.com">
        <meta name="theme-color" content="#317EFB"/>

        <title>{{ config('appconstants.app.name') }}</title>
        <link rel="stylesheet" href="{{ asset('/css/bulma.min.css')}}">

        <style>
            html {height: 100%;}
            body {background: #e6e6e6; min-height: 100%;}
        </style>
    </head>
    <body>

    @livewire('logware')

    </body>
</html>
