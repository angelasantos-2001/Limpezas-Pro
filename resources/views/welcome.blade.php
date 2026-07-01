<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" href="{{ asset('imagens/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/galeria.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fundo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categorias.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>Limpeza Pro - Serviços de Limpeza Premium | Orçamento Grátis</title>
</head>
<body>

    <!-- ============ HEADER / NAVBAR ============ -->
    <header>
        <div class="container navbar">
            <a href="#" class="logo-link">
                <img src="{{ asset('imagens/logo.png') }}" alt="Limpeza Pro" class="logo-img">
            </a>

            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menu">
                <span></span><span></span><span></span>
            </button>

            <ul class="nav-links" id="nav-links">
                <li class="nav-item"><a href="#porque">Porquê Limpeza Pro</a></li>
                <li class="nav-item"><a href="#galeria">Antes / Depois</a></li>
                <li class="nav-item"><a href="#historia">A Nossa História</a></li>
                <!-- Redireciona para a página de agendamento -->
                <li><a href="/agendamento" class="btn-header">Pedir Orçamento</a></li>
              @auth
                <li><a href="/agendamento"><span class="login">Olá, {{ Auth::user()->name }}!</span></a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
                <button type="submit" class="logout">Sair</button>
                </form>
            </li>
            @else
                <li><a href="/login" class="login">Login</a></li>
            @endauth
            </ul>
        </div>
    </header>

    <!-- ============ HERO ============ -->
    <section class="hero">
        <div class="container hero-content">
            <span class="hero-badge">✨ Serviço de Limpeza Premium em Portugal</span>
            <h1>Casas mais limpas,<br><span class="highlight">vidas mais leves.</span></h1>
            <p>A Limpeza Pro cuida da sua casa com planos diários, semanais ou mensais. Profissionais de confiança, preços fixos, sem surpresas.</p>
            <div class="hero-actions">
                <a href="/agendamento"><button class="btn-cta">Orçamento Grátis</button></a>
                <a href="#porque" class="btn-secondary">Saber mais ↓</a>
            </div>
        </div>
    </section>

    <!-- ============ CATEGORIAS DE SERVIÇOS ============ -->
    <section class="services-categories" id="servicos">
        <div class="container">
            <h2 class="section-title">O que precisares, nós resolvemos.</h2>
            <p class="section-subtitle">Escolha o serviço ideal para o seu lar ou empresa.</p>

            <div class="categories-grid">
                <div class="category-card">
                    <span class="category-icon">🏠</span>
                    <span>Limpeza Doméstica</span>
                </div>
                <div class="category-card">
                    <span class="category-icon">✨</span>
                    <span>Limpeza Profunda</span>
                </div>
                <div class="category-card">
                    <span class="category-icon">🛋️</span>
                    <span>Estofos</span>
                </div>
                <div class="category-card">
                    <span class="category-icon">🛏️</span>
                    <span>Colchões</span>
                </div>
                <div class="category-card">
                    <span class="category-icon">👕</span>
                    <span>Tratamento de Roupa</span>
                </div>
                <div class="category-card">
                    <span class="category-icon">🏢</span>
                    <span>Escritórios</span>
                </div>
                <div class="category-card">
                    <span class="category-icon">🧺</span>
                    <span>Apoio Doméstico</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PASSOS + PROMOÇÕES ============ -->
    <section class="steps-prices">
        <div class="container prices-layout">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 30px;">Marca o teu serviço em 3 passos.</h2>
                <ul class="steps-list">
                    <li class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-info">
                            <h3>Contactamos para confirmar preços</h3>
                            <p>Transparência total, sem surpresas na fatura final.</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-info">
                            <h3>Escolhe o dia e hora ideais</h3>
                            <p>Calendário em tempo real — tu decides quando.</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-info">
                            <h3>Recebe a equipa Limpeza Pro em casa</h3>
                            <p>Profissionais de confiança, produtos eficazes, resultado garantido.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="cards-promo-grid">
                <div class="promo-card">
                    <div class="promo-img" style="background-image: url('/imagens/senhora.webp');"></div>
                    <div class="promo-details">
                        <span class="promo-price">Desde €60</span>
                        <h4>Limpeza de Casa</h4>
                    </div>
                </div>
                <div class="promo-card">
                    <div class="promo-img" style="background-image: url('/imagens/chao.jpg');"></div>
                    <div class="promo-details">
                        <span class="promo-price">Desde €100</span>
                        <h4>Limpeza Profunda</h4>
                    </div>
                </div>
                <div class="promo-card">
                    <div class="promo-img" style="background-image: url('/imagens/estofo.webp');"></div>
                    <div class="promo-details">
                        <span class="promo-price">Desde €80</span>
                        <h4>Estofos e Camas</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PORQUÊ ESCOLHER ============ -->
    <section class="why-section" id="porque">
        <div class="container">
            <h2 class="section-title">Porquê escolher a Limpeza Pro?</h2>
            <p class="section-subtitle">Não é só limpeza. É confiança, dedicação e amor pelos detalhes.</p>

            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon">🛡️</div>
                    <h3>100% Confiança</h3>
                    <p>Equipa verificada, com histórico limpo e formação em higiene profissional.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon">📅</div>
                    <h3>Marcação Online</h3>
                    <p>Calendário em tempo real. Faça login, veja a disponibilidade e marque em 2 minutos.</p>
                </div>
                <div class="why-card">
                    <div class="why-icon">✅</div>
                    <h3>Satisfação Garantida</h3>
                    <p>Se algo não estiver perfeito, voltamos sem custo adicional. É o nosso compromisso.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PLANOS ============ -->
    <section class="plans-section">
        <div class="container">
            <h2 class="section-title">Os Nossos Planos de Limpeza</h2>
            <p class="section-subtitle">Escolha a regularidade perfeita para as suas necessidades</p>

            <div class="plans-grid">
                <div class="plan-card">
                    <div class="plan-title">PLANO MENSAL</div>
                    <div class="plan-price">Desde <strong>€60</strong> /visita</div>
                    <ul class="plan-features">
                        <li>Recomendado para casas com menor utilização</li>
                        <li>Perfeito para uma limpeza completa e de manutenção geral</li>
                        <li>Inclui higienização de todas as divisões principais</li>
                        <li>Flexibilidade na data</li>
                    </ul>
                    <a href="/agendamento" class="btn-plan">Marcar</a>
                </div>
                <div class="plan-card featured">
                    <div class="plan-badge">⭐ Mais Popular</div>
                    <div class="plan-title">PLANO PROFUNDA</div>
                    <div class="plan-price">Desde <strong>€100</strong> /visita</div>
                    <ul class="plan-features">
                        <li>Limpeza detalhada de todas as divisões, incluindo áreas de difícil acesso</li>
                        <li>Remoção eficaz de pó, gordura, manchas e sujidade acumulada</li>
                        <li>Higienização completa para um ambiente saudável e renovado</li>
                        <li>Ideal antes ou depois de mudanças</li>
                    </ul>
                    <a href="/agendamento" class="btn-plan">Marcar</a>
                </div>
                <div class="plan-card">
                    <div class="plan-title">PLANO PERSONALIZADO</div>
                    <div class="plan-price">Sob <strong>consulta</strong></div>
                    <ul class="plan-features">
                        <li>Frequência adaptada às suas necessidades (diária, semanal, quinzenal)</li>
                        <li>Serviços ajustados ao tipo de casa e estilo de vida</li>
                        <li>Flexibilidade total com a qualidade Limpeza Pro</li>
                        <li>Apoio dedicado à família</li>
                    </ul>
                    <a href="/agendamento" class="btn-plan">Pedir Orçamento</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ GALERIA ANTES / DEPOIS ============ -->
    <section class="gallery-section" id="galeria">
        <div class="container">
            <h2 class="section-title">Antes & Depois Limpeza Pro</h2>
            <p class="section-subtitle">Resultados reais. Mexa o cursor sobre as imagens para ver a diferença.</p>

            <div class="gallery-grid">
                <div class="before-after-card">
                    <img src="{{ asset('imagens/cozinha.jpg') }}" alt="Antes e depois - Cozinha">
                    <div class="ba-label">🍳 Cozinha</div>
                </div>
                <div class="before-after-card">
                    <img src="{{ asset('imagens/casabanho.jpg') }}" alt="Antes e depois - Casa de Banho">
                    <div class="ba-label">🛁 Casa de Banho</div>
                </div>
                <div class="before-after-card">
                    <img src="{{ asset('imagens/sofa.jpg') }}" alt="Antes e depois - Sofá">
                    <div class="ba-label">🛋️ Estofos</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ HISTÓRIA / FUNDADORA ============ -->
    <section class="trust-section" id="historia">
        <div class="container trust-layout">
            <div class="trust-content">
                <h2>A história da Limpeza Pro</h2>
                <p class="trust-intro"><strong>Olá! Sou a Angela.</strong> Programadora e curiosa.</p>
                <p>Criei este projeto para ajudar famílias a terem mais conforto, tempo e tranquilidade no dia a dia.</p>
                <ul class="trust-checklist">
                    <li>Limpezas domésticas</li>
                    <li>Tratamento de roupa</li>
                    <li>Apoio doméstico</li>
                </ul>
                <p>Trabalho com <strong>dedicação, confiança e atenção aos detalhes</strong> — porque cada casa merece cuidado.</p>
                <p class="trust-signature">— Angela, fundadora da Limpeza Pro</p>
            </div>
            <div class="trust-image-wrap">
                <img src="{{ asset('imagens/flor.webp') }}" alt="Angela, fundadora da Limpeza Pro" class="trust-img">
                <div class="trust-image-deco"></div>
            </div>
        </div>
    </section>

    <!-- ============ WHATSAPP FLUTUANTE ============ -->
    <a href="https://wa.me/351900000000" target="_blank" class="whatsapp-float" aria-label="Contactar via WhatsApp">
        <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
        <span class="whatsapp-tooltip">Fale connosco!</span>
    </a>

    <!-- ============ RODAPÉ ============ -->
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

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/script1.js') }}"></script>
    <script type="module" src="./src/main.js" defer></script>
    <!-- CÓDIGO DO MENU SEM DEPENDER DO VITE -->
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