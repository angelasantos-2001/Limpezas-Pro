<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950/20">
            
            <!-- Menu de Navegação com efeito Blur -->
            <div class="sticky top-0 z-40 backdrop-blur-md bg-white/80 dark:bg-slate-900/80 border-b border-slate-200/80 dark:border-slate-800/80">
                @include('layouts.navigation')
            </div>

            @hasSection('header')
    <header class="bg-white/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800/50">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                @yield('header')
            </h1>
        </div>
    </header>
@elseif(isset($header))
    <header class="bg-white/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800/50">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                {{ $header }}
            </h1>
        </div>
    </header>
@endif

            <!-- Page Content (Conteúdo Principal) -->
            <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 transition-all duration-300">
                <div class="animate-fade-in">
    @hasSection('content')
        @yield('content')
    @else
        {{ $slot ?? '' }}
    @endif
</div>
            </main>
        </div>
    </body>
</html>
