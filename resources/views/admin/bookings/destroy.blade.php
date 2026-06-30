@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px; margin: 60px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
    <div style="color: #e53e3e; font-size: 50px; margin-bottom: 10px;">⚠️</div>
    <h2 style="margin-bottom: 10px; color: #333;">Eliminar Agendamento</h2>
    <p style="color: #666; margin-bottom: 25px; line-height: 1.5;">
        Tens a certeza de que desejas remover permanentemente a marcação de <strong>{{ $booking->name }}</strong>?<br>
        <span style="color: #e53e3e; font-size: 14px;">(Esta ação também irá cancelar o evento no Google Calendar)</span>
    </p>

    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div style="display: flex; justify-content: space-between; gap: 15px;">
            <a href="{{ route('admin.reservas') }}" style="flex: 1; text-decoration: none; color: #333; background: #e2e8f0; padding: 12px; border-radius: 4px; font-weight: bold; display: inline-block;">
                Cancelar
            </a>
            <button type="submit" style="flex: 1; background: #e53e3e; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                Sim, Eliminar
            </button>
        </div>
    </form>
</div>
@endsection