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
    <title>Painel de Agendamento - Limpeza Pro</title>
</head>
<body>
     <header>
    <div class="container navbar">
            <a href="/" class="logo-link">
                <img src="{{ asset('imagens/logo.png') }}" alt="Limpeza Pro" class="logo-img">
            </a>
             @auth
            <ul class="nav-links">
                <li>  <span class="user-greeting">Olá, <strong>{{ Auth::user()->name }}</strong> 👋</span> </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="form-logout">
                        @csrf
                        <button type="submit" class="logout logout-btn">
                            Sair 
                        </button>
                    </form>
                </li>
                <li><a href="/" class="logout">← Voltar ao Início</a></li>
            </ul>
            @endauth
        </div>
    </header>

    <main class="container" style="margin-top: 40px; margin-bottom: 60px; min-height: 70vh;">
        
        @if(session('success'))
            <div class="alert alert-success" style="color: green; text-align:center; margin-bottom: 25px; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        @guest
            <div id="tela-login" style="text-align: center; max-width: 500px; margin: 50px auto; padding: 30px; border: 1px dashed var(--primary-color); border-radius: var(--border-radius);">
                <h2>Painel de Agendamento</h2>
                <p style="margin-bottom: 25px;">Por favor, faça login para visualizar a nossa agenda em tempo real e marcar um horário.</p>
                
                <div id="g_id_onload"
                     data-client_id="SEU_CLIENT_ID_AQUI.apps.googleusercontent.com"
                     data-callback="handleCredentialResponse"
                     data-auto_prompt="false">
                </div>
                <div class="g_id_signin" data-type="standard" style="display: inline-block; margin-bottom: 20px;"></div>

                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

                <p>ou utilize outra conta.</p>
                <a href="{{ route('login') }}" class="btn" style="background-color: var(--primary-color); color: white; padding: 10px 20px; display: inline-block; text-decoration: none; border-radius: 5px; margin-right: 10px;">Entrar</a>
                <a href="{{ route('register') }}" class="btn" style="background-color: var(--accent-color); color: white; padding: 10px 20px; display: inline-block; text-decoration: none; border-radius: 5px;">Criar Conta</a>
            </div>
        @endguest

        @auth
            <div id="tela-agenda">
                <div class="header-agenda" style="text-align: center; margin-bottom: 40px;">
                    <h2>Bem-vindo(a), {{ Auth::user()->name }}!</h2>
                    <p style="margin-bottom: 15px;">Selecione um dia disponível no calendário e preencha os dados para confirmar o serviço.</p>
                </div>

                <section class="booking-section">
                    <form action="{{ route('bookings.store') }}" method="POST" class="booking-layout">
                        @csrf
                        
                        <div class="calendar-container">
                            <div class="calendar-header">
                                <a href="{{ route('agendamento', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}" class="calendar-nav-btn">◀</a>
                                <h3 id="calendar-month-year">{{ ucfirst($nomeMesAno) }}</h3>
                                <a href="{{ route('agendamento', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}" class="calendar-nav-btn">▶</a>
                            </div>
                            
                            <div class="weekdays">
                                <div>DOM</div><div>SEG</div><div>TER</div><div>QUA</div><div>QUI</div><div>SEX</div><div>SÁB</div>
                            </div>
                            
                            <div class="days-grid" id="calendar-days">
                                @for ($i = 0; $i < $primeiroDiaDaSemana; $i++)
                                    <div class="day-empty"></div>
                                @endfor

                                @for ($dia = 1; $dia <= $diasNoMes; $dia++)
                                    @php
                                        $dataAtualLoop = \Carbon\Carbon::createFromDate($year, $month, $dia)->format('Y-m-d');
                                        $isPassado = \Carbon\Carbon::createFromDate($year, $month, $dia)->isPast();
                                        $isOcupado = in_array($dataAtualLoop, $datasOcupadas);
                                        
                                        // Verifica se o dia atual tem marcações parciais
                                        $isParcial = isset($datasParciais) && in_array($dataAtualLoop, $datasParciais);
                                        
                                        $classeStatus = 'free'; 
                                        if ($isPassado) {
                                            $classeStatus = 'past';
                                        } elseif ($isOcupado) {
                                            $classeStatus = 'busy';
                                        }
                                    @endphp

                                    <button
                                        type="button"
                                        class="calendar-day day-{{ $classeStatus }}"
                                        data-date="{{ $dataAtualLoop }}"
                                        {{ $isPassado || $isOcupado ? 'disabled' : '' }}
                                        style="position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; padding-bottom: 4px;"
                                    >
                                         <span>{{ $dia }}</span>

                                         @if($isParcial && !$isOcupado && !$isPassado)
                                             <span class="partial-dot" style="position: absolute; bottom: 5px; left: 50%; transform: translateX(-50%); width: 6px; height: 6px; background-color: #faa123; border-radius: 50%; display: block;"></span>
                                         @endif
                                    </button>
                                @endfor
                            </div>

                            <div class="calendar-legend" style="margin-top: 20px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                <span><span class="legend-dot legend-free" style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#28a745;"></span> Disponível</span>
                                <span><span class="legend-dot legend-partial" style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#faa123;"></span> Parcialmente Ocupado</span>
                                <span><span class="legend-dot legend-selected" style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#007bff;"></span> Selecionado</span>
                                <span><span class="legend-dot legend-busy" style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#dc3545;"></span> Ocupado</span>
                                <span><span class="legend-dot legend-past" style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#6c757d;"></span> Passado</span>
                            </div>
                        </div> 

                        <div class="booking-form-side">
                            <div class="selected-date-status" id="date-status">
                                📅 Nenhuma data selecionada
                            </div>

                            <input type="hidden" name="booking_date" id="booking_date" required>

                            <div class="form-group">
                                <label for="service-type">Tipo de Serviço</label>
                                <select id="service-type" name="service" required>
                                    <option value="" disabled selected>Escolha um serviço...</option>
                                    <option value="manutencao">Limpeza de Manutenção — desde €60</option>
                                    <option value="profunda">Limpeza Profunda (Ocupa o dia todo) — desde €100</option>
                                    <option value="estofos">Limpeza de Estofos — desde €80</option>
                                    <option value="colchao">Limpeza de Colchão — desde €70</option>
                                    <option value="personalizado">Plano Personalizado</option>
                                </select>
                            </div>

                            <div class="form-group" id="client-time-group">
                                <label for="booking_time">Horário Pretendido:</label>
                                <select name="booking_time" id="booking_time" required>
                                    <option value="" disabled selected>Escolha um dia no calendário primeiro...</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="client-name">Nome Completo</label>
                                <input type="text" id="client-name" name="name" value="{{ Auth::user()->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="client-phone">Contacto Telefónico</label>
                                <input type="tel" id="client-phone" name="phone" placeholder="91* *** ***" required>
                            </div>

                            <div class="form-group">
                                <label for="client-email">Email</label>
                                <input type="email" id="client-email" name="email" value="{{ Auth::user()->email }}" required>
                            </div>

                            <div class="form-group">
                                <label for="client-adress">Morada</label>
                                <input type="text" id="client-adress" name="address" placeholder="Rua Martins Azevedo nº2" value="{{ Auth::user()->adress }}" required>
                            </div>

                            <div class="form-group">
                                <label for="client-notes">Observações (opcional)</label>
                                <textarea id="client-notes" name="notes" rows="2" placeholder="Ex: tipologia T2, 80m², 2 casas de banho..."></textarea>
                            </div>

                            <button type="submit" class="btn-cta btn-block" id="btn-submit-booking">Confirmar Marcação ✓</button>
                            <p class="form-note">🔒 Os teus dados estão seguros. Não partilhamos com terceiros.</p>
                        </div>
                    </form>
                </section>
            </div>
        @endauth
    </main>

    <div id="toast">Este dia já se encontra totalmente ocupado!</div>

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
                    <li>📞 <a href="tel:+351910000000">+351 910 000 000</a></li>
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
    <script>
    window.agendaData = {
        horasOcupadas: @json($horasOcupadasPorDia ?? [])
    };
    </script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script type="module" src="/js/script.js"></script>
</body>
</html>