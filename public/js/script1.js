(function () {
    'use strict';

    // ============ CONFIGURAÇÕES GLOBAIS SEGURAS ============
    const API_KEY = import.meta && import.meta.env ? import.meta.env.VITE_API_KEY : '';
    const CALENDAR_ID = import.meta && import.meta.env ? import.meta.env.VITE_CALENDAR_ID : '';
    const WEB_APP_URL = import.meta && import.meta.env ? import.meta.env.VITE_WEB_APP_URL : '';

    const toast = document.getElementById("toast");

    // ============ INICIALIZAÇÃO DO MENU & DROPDOWNS ============
    function iniciarComponentesGlobais() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        if (menuToggle && navLinks) {
            menuToggle.addEventListener('click', function (e) {
                e.preventDefault();
                navLinks.classList.toggle('open');
            });
        }

        document.querySelectorAll('.dropdown-parent').forEach(parent => {
            const span = parent.querySelector('span');
            if (span) {
                span.addEventListener('click', (e) => {
                    if (window.innerWidth <= 968) {
                        e.preventDefault();
                        parent.classList.toggle('active');
                    }
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', iniciarComponentesGlobais);
    } else {
        iniciarComponentesGlobais();
    }

    // ============ UTILITÁRIO DE TOAST (ALERTAS) ============
    function showToast(message, type) {
        if (!toast) return;
        toast.innerText = message;
        toast.classList.remove('success');
        if (type === 'success') toast.classList.add('success');
        toast.style.display = 'block';
        clearTimeout(showToast._timer);
        showToast._timer = setTimeout(() => { toast.style.display = 'none'; }, 3500);
    }

    // ============ ANIMAÇÕES AO FAZER SCROLL ============
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.why-card, .plan-card, .promo-card, .category-card, .before-after-card, .step-item')
        .forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

    // ============ CALENDÁRIOS DO PAINEL ADMIN (FULLCALENDAR) ============
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Configuração para o elemento #calendar-admin
        const calendarAdminEl = document.getElementById('calendar-admin');
        if (calendarAdminEl) {
            const calendarAdmin = new FullCalendar.Calendar(calendarAdminEl, {
                initialView: 'dayGridMonth',
                locale: 'pt',
                firstDay: 1,
                editable: true, 
                selectable: true,
                events: '/api/todas-as-reservas', 
                eventClick: function(info) {
                    if (confirm("Desejas remover esta marcação do cliente?")) {
                        if (typeof eliminarMarcacao === 'function') {
                            eliminarMarcacao(info.event.id);
                        } else {
                            alert("Função 'eliminarMarcacao' não foi definida no escopo.");
                        }
                    }
                },
                eventDrop: function(info) {
                    let novaData = info.event.start.toISOString();
                    let marcacaoId = info.event.id;

                    fetch(`/admin/${marcacaoId}/atualizar-data`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({ nova_data: novaData })
                    })
                    .then(response => response.json())
                    .then(data => {
                        showToast('Marcação reagendada com sucesso!', 'success');
                    })
                    .catch(error => {
                        console.error('Erro na atualização:', error);
                        info.revert(); 
                    });
                }
            });
            calendarAdmin.render();
        }

        // 2. Configuração para o elemento secundário #calendar (Caso exista)
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt', 
                firstDay: 1,  
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                events: '/api/todas-as-reservas',
                eventClick: function(info) {
                    alert('Marcação: ' + info.event.title + '\nData/Hora: ' + info.event.start.toLocaleString('pt-PT'));
                },
                height: 'auto',
                handleWindowResize: true
            });
            calendar.render();
        }
    });

    // NOTA: A lógica duplicada do selectHoras que causava conflito com o primeiro script 
    // foi completamente centralizada no script mestre para evitar quebras visuais e falhas no bloqueio.

})();
