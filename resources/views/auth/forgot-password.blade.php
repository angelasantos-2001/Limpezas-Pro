<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Recuperar Palavra-passe - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased h-full text-slate-900 selection:bg-indigo-500 selection:text-white">
    
    <div class="min-h-screen flex flex-col justify-center items-center p-4 bg-gradient-to-br from-slate-50 via-white to-slate-100">
        
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 p-8 transition-all duration-300">
            
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-800">Recuperar Palavra-passe</h2>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                    Esqueceu-se da sua senha? Introduza o seu endereço de email e enviaremos um link para definir uma nova.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm placeholder:text-slate-400"
                        placeholder="exemplo@email.com">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 cursor-pointer">
                        Enviar Link de Recuperação
                        <svg class="ml-2 w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-sm text-slate-500">
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Voltar para o Login
                        </a>
                    </p>
                </div>

            </form>
        </div>

    </div>

</body>
</html>