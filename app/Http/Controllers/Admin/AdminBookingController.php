<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // 1. Mostra a lista de texto usando o teu admin/reservas.blade.php
    public function index()
    {
        $reservas = Booking::orderBy('booking_date', 'asc')->get();
        return view('admin.reservas', compact('reservas'));
    }

    // 2. Abre o formulário admin/bookings/edit.blade.php
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    // 3. Grava as alterações feitas na edição
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'nullable',
            'service'      => 'required|string',
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:30',
            'email'        => 'required|email',
            'address'      => 'required|string|max:255',
            'notes'        => 'nullable|string'
        ]);

        $booking->update($validated);

        return redirect()->route('admin.calendario')->with('success', 'Reserva atualizada com sucesso!');
    }

    // 4. Abre a tua página admin/bookings/destroy.blade.php para pedir confirmação
    public function deleteConfirm($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.destroy', compact('booking'));
    }

  public function destroy($id)
{
    // 1. Encontra a reserva
    $booking = \App\Models\Booking::findOrFail($id);
    
    // 2. Tenta apagar do Google Calendar
    if ($booking->google_event_id) { // Corrigido de $reserva para $booking
        try {
            config(['google-calendar.calendar_id' => 'angelasantos.asa.2001@gmail.com']);
            $event = \Spatie\GoogleCalendar\Event::find($booking->google_event_id);
            if ($event) {
                $event->delete();
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao apagar evento no Google: ' . $e->getMessage());
        }
    }

    // 3. Apaga da base de dados
    $booking->delete();
    
    // 4. Redireciona
    return redirect()->route('admin.calendario')->with('success', 'Marcação eliminada com sucesso!');
}
}