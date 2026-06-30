<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <title>Editar Marcação</title>
</head>
<body>

    <div class="container-card">
        <h2>Editar Marcação</h2>

        <!-- CORREÇÃO AQUI: Alterado de admin.bookings.edit para admin.bookings.update -->
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nome do Cliente</label>
                <input type="text" name="name" value="{{ old('name', $booking->name) }}" readonly>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $booking->email) }}" readonly>
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $booking->phone) }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Serviço</label>
                <!-- O select está disabled, mas enviamos o valor via hidden input -->
                <select name="service" disabled>
                    <option value="regular" {{ $booking->service == 'regular' ? 'selected' : '' }}>Limpeza Regular</option>
                    <option value="profunda" {{ $booking->service == 'profunda' ? 'selected' : '' }}>Limpeza Profunda</option>
                    <option value="estofos" {{ $booking->service == 'estofos' ? 'selected' : '' }}>Limpeza de Estofos</option>
                    <option value="colchao" {{ $booking->service == 'colchao' ? 'selected' : '' }}>Limpeza de Colchão</option>
                </select>
                <input type="hidden" name="service" value="{{ $booking->service }}">
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Data</label>
                    <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date) }}" required>
                </div>
                <div class="form-group">
                    <label>Horário</label>
                    <input type="time" name="booking_time" value="{{ old('booking_time', $booking->booking_time ? substr($booking->booking_time, 0, 5) : '') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Morada</label>
                <input type="text" name="address" value="{{ old('address', $booking->address) }}" readonly>
            </div>

            <div class="form-group">
                <label>Observações</label>
                <textarea name="notes" rows="3" readonly>{{ old('notes', $booking->notes) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Guardar Alterações</button>
            <a href="{{ route('admin.calendario') }}" class="back-link">Voltar ao Calendário</a>
        </form>
    </div>

</body>
</html>