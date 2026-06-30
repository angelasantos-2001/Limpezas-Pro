<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class AgeendaController extends Controller
{
    public function index(Request $request)
{
    $month = (int) $request->input('month', now()->month);
    $year  = (int) $request->input('year',  now()->year);

    $primeiroDia = \Carbon\Carbon::createFromDate($year, $month, 1);
    $diasNoMes = $primeiroDia->daysInMonth;
    $primeiroDiaDaSemana = $primeiroDia->dayOfWeek;
    $nomeMesAno = $primeiroDia->translatedFormat('F Y');

    // Dias totalmente ocupados (BD ou Google)
    $datasOcupadas = Booking::whereYear('booking_date', $year)
        ->whereMonth('booking_date', $month)
        ->where('service', 'like', '%profunda%')
        ->pluck('booking_date')
        ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
        ->toArray();

    // Mapa de horários ocupados por dia (para o JS)
    $agendaData = [];
    foreach (Booking::whereYear('booking_date', $year)->whereMonth('booking_date', $month)->get() as $b) {
        $iso = \Carbon\Carbon::parse($b->booking_date)->format('Y-m-d');
        if (!isset($agendaData[$iso])) {
            $agendaData[$iso] = ['diaInteiro' => false, 'horasOcupadas' => []];
        }
        if (str_contains(strtolower($b->service), 'profunda')) {
            $agendaData[$iso]['diaInteiro'] = true;
        } elseif ($b->booking_time) {
            $agendaData[$iso]['horasOcupadas'][] = substr($b->booking_time, 0, 5);
        }
    }

    return view('agenda.index', [
        'month' => $month,
        'year'  => $year,
        'diasNoMes' => $diasNoMes,
        'primeiroDiaDaSemana' => $primeiroDiaDaSemana,
        'nomeMesAno' => $nomeMesAno,
        'datasOcupadas' => $datasOcupadas,
        'agendaDataJson' => json_encode($agendaData),
    ]);
}
}