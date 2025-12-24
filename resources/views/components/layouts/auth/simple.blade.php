<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-zinc-900">
        {{-- Allow full-screen content for login page --}}
        {{ $slot }}
        
        @fluxScripts
        @stack('scripts')
    </body>
</html>

