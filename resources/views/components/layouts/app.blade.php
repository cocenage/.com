<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen flex flex-col justify-between max-w-2xl mx-auto px-[48px]">
    <livewire:partials.header />
    {{ $slot }}
    <livewire:partials.footer />
</body>

</html>
