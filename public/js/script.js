(function () {
    'use strict';

    // ============ CONFIGURAÇÕES GLOBAIS (Seguras contra Erros) ============
    const API_KEY = ""; 
    const CALENDAR_ID = "";
    const WEB_APP_URL = "";

    // ============ SELETORES DE ELEMENTOS ============
    const serviceTypeSelect = document.getElementById("service-type");
    const timeGroup = document.getElementById("client-time-group");
    const timeSelect = document.getElementById("client-time");
    const bookingDateInput = document.getElementById('booking_date');
    const bookingTimeSelect = document.getElementById('booking_time');
    const dateStatus = document.getElementById("date-status");
    const toast = document.getElementById("toast");
    const btnSubmitBooking = document.getElementById("btn-submit-booking");

    // Inputs adicionais
    const clientNameInput = document.getElementById("client-name");
    const clientEmailInput = document.getElementById("client-email");
    const clientPhoneInput = document.getElementById("client-phone");
    const clientNotesInput = document.getElementById("client-notes");

    let selectedDayBtn = null;
    let selectedDateISO = '';
    const TURNOS_PADRAO = ['09:00', '11:00', '14:00', '16:00'];

    // ============ GATILHO DE CLIQUE ULTRA-AGRESSIVO ============
    document.addEventListener('mousedown', function (e) {
        const btn = e.target.closest('.calendar-day');
        if (!btn) return;

        // Força a ativação mesmo que o HTML tenha a classe disabled
        e.preventDefault();
        e.stopPropagation();

        console.log("Dia detetado e clicado com sucesso:", btn.dataset.date || btn.getAttribute('data-date'));

        // Limpa seleções anteriores
        document.querySelectorAll('.day-selected, .selected, .calendar-day').forEach(el => {
            el.classList.remove('day-selected', 'selected');
        });

        // Marca o novo dia visualmente
        btn.classList.add('day-selected', 'selected');
        selectedDayBtn = btn;
        selectedDateISO = btn.dataset.date || btn.getAttribute('data-date');

        // Atualiza o hidden input para o Laravel
        if (bookingDateInput) bookingDateInput.value = selectedDateISO;

        // Atualiza o status visual
        if (dateStatus) {
            const dataFmt = formatarDataPT(selectedDateISO);
            dateStatus.innerHTML = `✅ Data selecionada: <strong>${dataFmt}</strong>`;
        }

        // Atualiza os horários disponíveis
        atualizarHorariosDisponiveis(selectedDateISO);
    }, true); 

    function atualizarHorariosDisponiveis(iso) {
        if (!bookingTimeSelect) return;
        bookingTimeSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.disabled = true;
        placeholder.selected = true;
        placeholder.innerText = 'Escolha um horário livre...';
        bookingTimeSelect.appendChild(placeholder);

        // Tratamento flexível da estrutura de dados vinda do Laravel
        let infoDia = {};
        if (window.agendaData) {
            if (window.agendaData[iso]) {
                infoDia = window.agendaData[iso];
            } else if (window.agendaData.horasOcupadas && window.agendaData.horasOcupadas[iso]) {
                infoDia = { horasOcupadas: window.agendaData.horasOcupadas[iso] };
            }
        }
        
        const horasOcupadas = infoDia.horasOcupadas || [];

        if (infoDia.diaInteiro) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.disabled = true;
            opt.innerText = '❌ Dia totalmente ocupado';
            bookingTimeSelect.appendChild(opt);
            return;
        }

        const normalizarHora = (str) => str.toString().replace(/[:h\s]/g, '').substring(0, 4);

        TURNOS_PADRAO.forEach(hora => {
            const option = document.createElement('option');
            option.value = hora;
            
            const textoExibicao = hora.replace(':', 'h');

            // Varre a lista de ocupados usando a nossa limpeza de strings para garantir correspondência ideal
            const estaOcupado = horasOcupadas.some(hOcupada => 
                normalizarHora(hOcupada) === normalizarHora(hora) ||
                normalizarHora(hOcupada) === normalizarHora(textoExibicao)
            );

            if (estaOcupado) {
                // Em vez de sumir com a opção, desativamos com elegância visual
                option.textContent = `${textoExibicao} — (Indisponível 🔒)`;
                option.disabled = true;
                option.style.color = '#aaa';
                option.style.textDecoration = 'line-through';
            } else {
                option.textContent = textoExibicao;
            }

            bookingTimeSelect.appendChild(option);
        });
    }

    if (serviceTypeSelect) {
        serviceTypeSelect.addEventListener('change', (e) => {
            if (e.target.value === 'profunda') {
                if (timeGroup) timeGroup.style.display = 'none';
                if (bookingTimeSelect) bookingTimeSelect.required = false;
            } else {
                if (timeGroup) timeGroup.style.display = 'block';
                if (bookingTimeSelect) bookingTimeSelect.required = true;
                if (selectedDateISO) atualizarHorariosDisponiveis(selectedDateISO);
            }
        });
    }

    function formatarDataPT(iso) {
        if (!iso) return "";
        const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        const partes = iso.split('-');
        if (partes.length !== 3) return iso;
        const [ano, mes, dia] = partes;
        return `${parseInt(dia)} de ${meses[parseInt(mes) - 1]} de ${ano}`;
    }

    function showToast(message, type) {
        if (!toast) return;
        toast.innerText = message;
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 3500);
    }

    // Código Mobile Simplificado
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', () => navLinks.classList.toggle('open'));
    }

})();