<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased">
    {{-- The main content with `full-width` --}}
    <x-mary-main full-width full-height>
        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-300">
            <livewire:sidebar-menu />
        </x-slot:sidebar>
        {{-- The `$slot` goes here --}}
        <x-slot:content>
            <div
                class="absolute top-0 left-0 w-full h-full opacity-50 -z-20 bg-gradient-to-tr from-base-200 to-primary/10">
            </div>
            <div class="absolute top-0 left-0 w-full h-full bg-repeat bg-[220px] -z-10 opacity-20 bg-noise-pattern">
            </div>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>
    {{--  TOAST area --}}
    <x-mary-toast />
</body>

</html>
