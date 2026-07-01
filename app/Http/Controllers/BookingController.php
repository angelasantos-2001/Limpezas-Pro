<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Lógica do Calendário de Agendamento do Cliente (Vista: agendamento.blade.php)
     */
    public function index(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year  = (int) $request->input('year',  now()->year);

        $primeiroDia = Carbon::createFromDate($year, $month, 1);
        $diasNoMes = $primeiroDia->daysInMonth;
        $primeiroDiaDaSemana = $primeiroDia->dayOfWeek;
        $nomeMesAno = $primeiroDia->translatedFormat('F Y');

        // 1. Horários padrão oferecidos por dia
        $horariosPadrao = ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'];
        $totalTurnosPorDia = count($horariosPadrao);

        // 2. Procura as marcações deste mês específico
        $bookingsDoMes = Booking::whereYear('booking_date', $year)
            ->whereMonth('booking_date', $month)
            ->get();

        $horasOcupadasPorDia = [];
        $datasOcupadas = [];
        $datasParciais = [];
        $agendaData = [];

        // 3. Organiza as marcações por dia e hora
        foreach ($bookingsDoMes as $b) {
            $iso = Carbon::parse($b->booking_date)->format('Y-m-d');
            
            if (!isset($agendaData[$iso])) {
                $agendaData[$iso] = ['diaInteiro' => false, 'horasOcupadas' => []];
            }
            if (!isset($horasOcupadasPorDia[$iso])) {
                $horasOcupadasPorDia[$iso] = [];
            }

            // Bloqueio por Limpeza Profunda (ocupa o dia todo)
            if (str_contains(strtolower($b->service), 'profunda')) {
                $agendaData[$iso]['diaInteiro'] = true;
                $datasOcupadas[] = $iso;
                $horasOcupadasPorDia[$iso] = $horariosPadrao; 
            } elseif ($b->booking_time) {
                $horaFormatada = substr($b->booking_time, 0, 5);
                $agendaData[$iso]['horasOcupadas'][] = $horaFormatada;
                $horasOcupadasPorDia[$iso][] = $horaFormatada;
            }
        }

        // 4. Validação dos estados (Livre, Parcial ou Cheio)
        foreach ($horasOcupadasPorDia as $iso => $horas) {
            $horasUnicas = array_unique($horas);
            $horasOcupadasPorDia[$iso] = array_values($horasUnicas);

            if (in_array($iso, $datasOcupadas)) {
                continue;
            }

            if (count($horasUnicas) >= $totalTurnosPorDia) {
                $datasOcupadas[] = $iso;
            } elseif (count($horasUnicas) > 0) {
                $datasParciais[] = $iso;
            }
        }

        $datasOcupadas = array_unique($datasOcupadas);

        return view('agendamento', [
            // Mudado para corresponder exatamente à variável que o agendamento.blade precisa
            'month' => $month,
            'year'  => $year,
            'diasNoMes' => $diasNoMes,
            'primeiroDiaDaSemana' => $primeiroDiaDaSemana,
            'nomeMesAno' => $nomeMesAno,
            'datasOcupadas' => $datasOcupadas,
            'datasParciais' => $datasParciais,
            'horasOcupadasPorDia' => $horasOcupadasPorDia,
            'agendaDataJson' => json_encode($agendaData),
        ]);
    }

    /**
     * Gravação de nova marcação (Vinda do formulário do cliente)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'nullable|date_format:H:i',
            'service'      => 'required|string',
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:30',
            'email'        => 'required|email',
            'notes'        => 'nullable|string|max:500',
            'address'      => 'required|string|max:255'
        ]);

        // 1) Grava na BD com o ID do utilizador logado
       $booking = Booking::create($validated + [
        'user_id' => auth()->id(),
        'confirmation_token' => Str::random(40)
        ]);

        // 2) Integração direta com Google Calendar via Spatie
        try {
            config(['google-calendar.calendar_id' => 'angelasantos.asa.2001@gmail.com']);
            $event = new \Spatie\GoogleCalendar\Event;
            
            $event->name = 'Limpeza Pro - ' . ucfirst($validated['service']) . ' (' . $validated['name'] . ')';
            $event->description = "Cliente: {$validated['name']}\nTelefone: {$validated['phone']}\nNotas: " . ($validated['notes'] ?? 'Nenhuma');

            $hora = $validated['booking_time'] ?? '09:00';
            $startDateTime = Carbon::parse($validated['booking_date'] . ' ' . $hora);

            if (str_contains(strtolower($validated['service']), 'profunda')) {
                $event->startDate = Carbon::parse($validated['booking_date']);
                $event->endDate = Carbon::parse($validated['booking_date']);
            } else {
                $event->startDateTime = $startDateTime;
                $event->endDateTime = $startDateTime->copy()->addHours(2); 
            }

            $googleEvent = $event->save();
            
            if ($googleEvent && isset($googleEvent->id)) {
                $booking->update(['google_event_id' => $googleEvent->id]);
            }

        } catch (\Throwable $e) {
            \Log::error('Erro Crítico Google Calendar: ' . $e->getMessage());
        }

        // 3) Envio do Email de Confirmação
        try {
            $userMock = new \App\Models\User();
            $userMock->name = $validated['name'];
            $userMock->email = $validated['email'];
            $booking->setRelation('user', $userMock);

            Mail::send('emails.booking_confirmed', ['booking' => $booking], function($message) use ($validated) {
                $message->to($validated['email'])
                        ->subject('Confirmação do teu Agendamento - Limpeza Pro 🎉');
            });
            
        } catch (\Throwable $mailError) {
            \Log::error('Erro Crítico Envio de Email: ' . $mailError->getMessage());
        }

        return redirect('/agendamento')->with('success', 'Reserva efetuada com sucesso!');
        }

    /**
     * Lógica do painel visual do administrador (Vista: admin.calendario)
     */
    public function adminCalendar()
    {
        $bookings = Booking::all(); 

        $eventosIds = $bookings->map(function ($booking) {
            
            // 1. Evita o 00:00h. Se não houver hora na BD, assume as 09:00 por padrão
            $horaInicio = $booking->booking_time ?? '09:00:00';
            $start = $booking->booking_date . 'T' . $horaInicio;
            
            // 2. Define a duração com base no tipo de serviço
            if ($booking->service === 'profunda') {
                $duracaoHoras = 8; // Ocupa 8 horas no dia!
            } else {
                $duracaoHoras = 2; // Limpeza regular ou estofos ocupam 2 horas
            }
            
            // 3. Calcula automaticamente a hora de término (Soma X horas ao início)
            $end = date('Y-m-d\TH:i:s', strtotime("$start + $duracaoHoras hours"));

            return [
                'id'    => $booking->id,
                'title' => ($booking->service === 'profunda' ? 'Profunda ⚠️' : $booking->service) . ' - ' . ($booking->name ?? 'Cliente'),
                'start' => $start,
                'end'   => $end, // <--- ESTA LINHA DIZ AO FULLCALENDAR PARA ESTICAR O BLOCO!
                'extendedProps' => [
                    'cliente'    => $booking->name ?? 'Não registado',
                    'servico'    => $booking->service,
                    'hora'       => date('H:i', strtotime($horaInicio)),
                    'edit_url'   => route('admin.bookings.edit', $booking->id),     
                    'delete_url' => route('admin.bookings.destroy', $booking->id),  
                ]
            ];
        });

        return view('admin.calendario', ['eventosIds' => $eventosIds]);
    }
    public function update(Request $request, $id)
{
    // 1. Encontra a reserva
    $booking = Booking::findOrFail($id);

    // 2. Validação básica (opcional, mas recomendado)
    $request->validate([
        'booking_date' => 'required|date',
        'booking_time' => 'required',
    ]);

    // 3. Atualiza APENAS o que permitiste (Data e Hora)
    $booking->update([
        'booking_date' => $request->booking_date,
        'booking_time' => $request->booking_time,
    ]);

    // 4. Redireciona para a listagem
    return redirect()->route('admin.bookings.index')->with('success', 'Marcação atualizada com sucesso!');
}

public function edit($id)
{
    // Substitua 'Booking' pelo nome exato do seu Model de reservas se for diferente
    $booking = \App\Models\Booking::findOrFail($id); 

    return view('admin.bookings.edit', compact('booking'));
}

public function confirm($token)
{
    $booking = Booking::where('confirmation_token', $token)->firstOrFail();

    if ($booking->status === 'confirmado') {
        return "Esta marcação já foi validada anteriormente.";
    }

    $booking->status = 'confirmado';
    $booking->save();

    return "Sucesso! A sua marcação foi validada com sucesso. Obrigado!";
}
    
}