@extends('layouts.app')

@section('content')
    <h1>Todas as Reservas</h1>
    
    {{-- Corrigido para $reservas (conforme o AdminBookingController envia) --}}
    @forelse($reservas as $reserva)
        <div class="reserva-card">
            {{-- Corrigido para as colunas reais: name e booking_date --}}
            <p>Cliente: {{ $reserva->name }} - Data: {{ $reserva->booking_date }} - Hora: {{ $reserva->booking_time }}</p>
            
            {{-- Corrigido para usar a rota do AdminBookingController --}}
            <form action="{{ route('admin.bookings.destroy', $reserva->id) }}" method="POST" onsubmit="return confirm('Apagar esta reserva?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Apagar</button>
            </form>
        </div>
    @empty
        <p>Nenhuma marcação encontrada na base de dados.</p>
    @endforelse
@endsection