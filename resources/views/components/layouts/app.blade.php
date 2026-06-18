<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? __('common.meta_title') }} — {{ config('app.name') }}</title>
        <meta name="description" content="{{ $description ?? __('common.meta_description') }}">

        <link rel="icon" href="/favicon.ico?v=2" sizes="any">
        <link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png?v=2">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png?v=2">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png?v=2">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-paper bg-grain text-ink antialiased min-h-screen flex flex-col">
        <a href="#main"
           class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-ink focus:text-paper focus:px-4 focus:py-2 focus:font-mono focus:text-sm">
            {{ __('common.skip_to_content') }}
        </a>

        <x-nav />

        <main id="main" class="flex-1">
            {{ $slot }}
        </main>

        <x-footer />

        @livewireScripts
    </body>
</html>
