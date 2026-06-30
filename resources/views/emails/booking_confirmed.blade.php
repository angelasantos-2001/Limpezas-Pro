<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Agendamento</title>
    <style>
        body { font-family: 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333333; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 5px solid #007bff; }
        .email-header { background-color: #007bff; padding: 30px; text-align: center; color: #ffffff; }
        .email-header h1 { margin: 0; font-size: 24px; }
        .email-body { padding: 30px; line-height: 1.6; }
        .booking-details { background-color: #f8f9fa; border-left: 4px solid #007bff; padding: 15px; margin: 20px 0; border-radius: 4px; list-style: none; }
        .booking-details li { margin-bottom: 10px; font-size: 15px; }
        .booking-details li:last-child { margin-bottom: 0; }
        .email-footer { background-color: #f1f1f1; text-align: center; padding: 20px; font-size: 12px; color: #777777; border-top: 1px solid #ebeeec; }
        .btn { display: inline-block; padding: 10px 20px; color: #ffffff !important; background-color: #007bff; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <h1>Agendamento Confirmado! 🎉</h1>
        </div>

        <div class="email-body">
            <h2>Olá, {{ $booking->user->name ?? 'Cliente' }}!</h2>
            <p>A tua marcação foi registada com sucesso no nosso sistema. Aqui estão todos os detalhes do teu serviço:</p>

            <ul class="booking-details">
                <li><strong>Serviço:</strong> {{ ucfirst($booking->service) }}</li>
                <li><strong>Data:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</li>
                <li>
                    <strong>Hora:</strong> 
                    @if($booking->booking_time)
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H\h i') }}
                    @else
                        A definir
                    @endif
                </li>
                <li><strong>Morada:</strong> {{ $booking->address ?? 'Morada não fornecida' }}</li>
            </ul>

            <p>Se precisares de alterar a tua marcação ou tiveres alguma dúvida, contacta-nos através do número <strong>91* *** ***</strong> ou responde diretamente a este e-mail.</p>
            
            <p>Obrigado por escolheres a <strong>Limpeza Pro</strong>!</p>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Limpeza Pro. Todos os direitos reservados.</p>
            <p>Este é um e-mail automático, por favor não respondas caso não precises de suporte.</p>
        </div>
    </div>

</body>
</html>