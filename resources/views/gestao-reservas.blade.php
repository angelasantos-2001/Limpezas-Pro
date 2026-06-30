@foreach($bookings as $booking)
    <div class="card-reserva">
        <p>Cliente: {{ $booking->name }}</p>
        
        @if(auth()->check() && auth()->user()->email === 'angelasantos.asa.2001@gmail.com')
            <form action="{{ route('agendamento.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apagar esta reserva?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
            </form>
        @endif
    </div>
@endforeach