<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="max-w-2xl mx-auto pt-[80px] py-[48px] pb-[48px]">
    <livewire:partials.header />
    {{ $slot }}
    <livewire:partials.footer />
</body>

</html>
