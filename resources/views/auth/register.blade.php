<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Criar Conta - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased h-full text-slate-900 selection:bg-indigo-500 selection:text-white">
    
    <!-- Contentor principal que centraliza tudo na vertical e horizontal -->
    <div class="min-h-screen flex flex-col justify-center items-center p-4 bg-gradient-to-br from-slate-50 via-white to-slate-100">
        
        <!-- Card de Registo Moderno -->
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 p-8 transition-all duration-300">
            
            <!-- Cabeçalho do Card (Sem imagem/logótipo) -->
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-800">Criar uma Conta</h2>
                <p class="text-sm text-slate-500 mt-1">Introduza os seus dados para começar</p>
            </div>

            <!-- Formulário Laravel -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Campo: Nome -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nome</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm placeholder:text-slate-400"
                        placeholder="O seu nome completo">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm placeholder:text-slate-400"
                        placeholder="exemplo@email.com">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Palavra-passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Palavra-passe</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm placeholder:text-slate-400"
                        placeholder="**********">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Confirmar Palavra-passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirmar Palavra-passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm placeholder:text-slate-400"
                        placeholder="**********">
                    @error('password_confirmation')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botão Registar (Estilo Azul/Índigo Profissional) -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 cursor-pointer">
                        Registar
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Link de Alternância (Centralizado no fundo) -->
                <div class="text-center pt-2">
                    <p class="text-sm text-slate-500">
                        Já está registado? 
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors ml-1">
                            Iniciar Sessão
                        </a>
                    </p>
                </div>

            </form>
        </div>

    </div>

</body>
</html>