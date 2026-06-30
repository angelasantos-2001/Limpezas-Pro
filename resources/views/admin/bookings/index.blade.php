<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('imagens/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/galeria.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fundo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <title>Lista de Marcações - Limpeza Pro</title>
</head>
<body>
    <header>
        <div class="container navbar">
            <a href="/" class="logo-link">
                <img src="{{ asset('imagens/logo.png') }}" alt="Limpeza Pro" class="logo-img">
            </a>
            
            @auth
                <div class="user-menu" style="display: flex; align-items: center; gap: 15px;">
                    <span style="color: var(--text-color);">Olá, <strong>{{ Auth::user()->name }}</strong> 👋</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout">
                            Sair 
                        </button>
                    </form>
                </div>
            @else
                <a href="/" class="btn-secondary">← Voltar ao Início</a>
            @endauth
        </div>
    </header>

    <main class="container" style="margin-top: 40px; margin-bottom: 60px; min-height: 70vh;">
        
        @if(session('success'))
            <div class="alert alert-success" style="color: green; text-align:center; margin-bottom: 25px; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
            <div class="dashboard-title">
                <h2 style="font-size: 2rem; margin-bottom: 5px;">Gestão de Marcações</h2>
                <p style="color: #666;">Visualiza, planeia e gere os agendamentos de limpeza dos teus clientes.</p>
            </div>
            
            <div class="view-toggle" style="display: flex; gap: 10px;">
                <a href="/admin/reservas" class="btn" style="background-color: #eee; color: #333; padding: 10px 15px; text-decoration: none; border-radius: 5px;">📅 Calendário</a>
                <a href="#" class="btn" style="background-color: var(--primary-color); color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">📋 Lista de Texto</a>
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #efefef; background-color: #f9f9f9;">
                        <th style="padding: 12px;">Cliente</th>
                        <th style="padding: 12px;">Data</th>
                        <th style="padding: 12px;">Serviço</th>
                        <th style="padding: 12px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $m)
                        <tr style="border-bottom: 1px solid #efefef;">
                            <td style="padding: 12px;">{{ $m->user->name ?? $m->name ?? 'Cliente Externo' }}</td>
                            <td style="padding: 12px;">{{ \Carbon\Carbon::parse($m->booking_date)->format('d/m/Y') }}</td>
                            <td style="padding: 12px; text-transform: capitalize;">{{ $m->service }}</td>
                            <td style="padding: 12px; text-align: center; display: flex; justify-content: center; gap: 15px;">
                                
                                <a href="{{ route('admin.bookings.edit', $m->id) }}" style="color: #2b6cb0; font-weight: 500; text-decoration: none;">Editar</a>
                                
                                <form action="{{ route('admin.bookings.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja apagar esta marcação?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: 500;">Apagar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 20px; text-align: center; color: #777;">Nenhuma marcação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="container footer-grid">
            <div class="footer-col footer-brand">
                <img src="{{ asset('imagens/logo.png') }}" alt="Limpeza Pro" class="footer-logo">
                <p>Casas mais limpas, vidas mais leves. Serviço de limpeza premium criado com dedicação e atenção aos detalhes.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Facebook">📘</a>
                    <a href="#" aria-label="Instagram">📷</a>
                    <a href="#" aria-label="TikTok">🎵</a>
                    <a href="https://wa.me/351900000000" aria-label="WhatsApp">💬</a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Serviços</h4>
                <ul>
                    <li><a href="#servicos">Limpeza Doméstica</a></li>
                    <li><a href="#servicos">Limpeza Profunda</a></li>
                    <li><a href="#servicos">Estofos & Colchões</a></li>
                    <li><a href="#servicos">Tratamento de Roupa</a></li>
                    <li><a href="#servicos">Apoio Doméstico</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Empresa</h4>
                <ul>
                    <li><a href="#historia">A Nossa História</a></li>
                    <li><a href="#porque">Porquê Limpeza Pro</a></li>
                    <li><a href="#galeria">Antes & Depois</a></li>
                    <li><a href="/agendamento">Pedir Orçamento</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contactos</h4>
                <ul class="footer-contacts">
                    <li>📞 <a href="tel:+351900000000">+351 900 000 000</a></li>
                    <li>✉️ <a href="mailto:geral@limpezapro.pt">geral@limpezapro.pt</a></li>
                    <li>📍 Portugal</li>
                    <li>🕐 Seg–Sáb: 09h–18h</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2026 Limpeza Pro — Serviços de Limpeza. Todos os direitos reservados.</p>
                <p><a href="#">Política de Privacidade</a> · <a href="#">Termos & Condições</a></p>
            </div>
        </div>
    </footer>
</body>
</html>