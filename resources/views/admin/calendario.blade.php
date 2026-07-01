<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração - Limpezas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/galeria.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fundo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
    <div class="container navbar">
            <a href="#" class="logo-link">
                <img src="{{ asset('imagens/logo.png') }}" alt="Limpeza Pro" class="logo-img">
            </a>

             <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menu">
                <span></span><span></span><span></span>
            </button>

             @auth
            <ul class="nav-links" id="nav-links">
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
             @endauth
            </ul>
           
        </div>
    </header>

    <main class="dashboard-container">
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>Calendário de Marcações</h1>
                <p>Clica num dia para ver a agenda detalhada. Clica numa marcação para a alterar ou eliminar.</p>
            </div>
        </div>

        <div class="calendar-card">
            <div id="calendar"></div>
        </div>
    </main>

    <div id="actionModal" class="modal">
        <div class="modal-content">
            <h3 id="modal-client-name">Nome do Cliente</h3>
            <p id="modal-service-details">Detalhes do Serviço</p>
            
            <div class="action-buttons">
                <a href="#" id="btn-edit-link" class="btn-edit">Editar</a>
                
                <form id="delete-form" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="return confirm('Tens a certeza que queres eliminar esta marcação?');">Eliminar</button>
                </form>
                
                <button id="closeActionModal" class="btn-close">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/pt.global.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="{{ asset('js/script1.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script type="module" src="./src/main.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventosAgendados = @json($eventosIds ?? []);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Começa no mês
                locale: 'pt',                // Tudo em Português
                firstDay: 1,                 // Começa à 2ª Feira
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay' // Botões para alternar entre Mês e Dia
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    day: 'Dia'
                },
                events: eventosAgendados,
                slotMinTime: '09:00:00', // (Opcional) A que horas começa o calendário do dia
                slotMaxTime: '18:00:00', // (Opcional) A que horas acaba
                
                // 1. QUANDO CLICAS NUM DIA VAZIO DO MÊS
                dateClick: function(info) {
                    // Muda automaticamente o calendário para mostrar as horas desse dia!
                    calendar.changeView('timeGridDay', info.dateStr);
                },

                // 2. QUANDO CLICAS NUMA MARCAÇÃO JÁ EXISTENTE
                eventClick: function(info) {
                    // Impede que o link padrão do evento faça a página saltar
                    info.jsEvent.preventDefault(); 
                    
                    // Extrai as informações passadas pelo Controller
                    let props = info.event.extendedProps;
                    
                    // Preenche o modal com os dados
                    document.getElementById('modal-client-name').innerText = props.cliente || info.event.title;
                    document.getElementById('modal-service-details').innerText = `Serviço: ${props.servico || 'N/A'} às ${props.hora}h`;
                    
                    // Configura o link do botão de Editar
                    document.getElementById('btn-edit-link').href = props.edit_url;
                    
                    // Configura o action do formulário de Eliminar
                    document.getElementById('delete-form').action = props.delete_url;

                    // Abre o modal
                    document.getElementById('actionModal').style.display = 'block';
                }
            });

            calendar.render();

            // Lógica para fechar o Modal de Ações
            const modal = document.getElementById('actionModal');
            document.getElementById('closeActionModal').onclick = () => modal.style.display = 'none';
            window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const navLinks = document.getElementById('nav-links');

            if (menuToggle && navLinks) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    navLinks.classList.toggle('open');
                });
                
                // Fecha o menu ao clicar em qualquer link lá dentro
                navLinks.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navLinks.classList.remove('open');
                    });
                });
            }
        });
    </script>
</body>
</html>