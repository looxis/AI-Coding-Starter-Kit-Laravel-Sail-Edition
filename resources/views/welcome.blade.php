<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 text-gray-900">
        <div class="flex min-h-screen flex-col items-center justify-center">
            <h1 class="text-2xl font-semibold">{{ config('app.name', 'Laravel') }}</h1>
            <p class="mt-2 text-gray-500">Laravel + Sail base is running.</p>
        </div>
    </body>
</html>
