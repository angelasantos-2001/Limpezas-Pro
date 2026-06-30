<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recuperação de Palavra-passe</title>
    <style>
        /* O MESMO CSS DO TEU EMAIL DE CONFIRMAÇÃO */
        body { font-family: 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333333; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 5px solid #007bff; }
        .email-header { background-color: #007bff; padding: 30px; text-align: center; color: #ffffff; }
        .email-header h1 { margin: 0; font-size: 24px; }
        .email-body { padding: 30px; line-height: 1.6; }
        .email-footer { background-color: #f1f1f1; text-align: center; padding: 20px; font-size: 12px; color: #777777; border-top: 1px solid #ebeeec; }
        .btn { display: inline-block; padding: 10px 20px; color: #ffffff !important; background-color: #007bff; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Recuperação de Palavra-passe 🎉</h1>
        </div>
        <div class="email-body">
            <h2>Olá, {{ $user->name }}!</h2>
            <p>Recebeste este pedido de recuperação de palavra-passe para a tua conta Limpeza Pro.</p>
            
            <p>Clica no botão abaixo para definir uma nova password:</p>
            <center><a href="{{ $url }}" class="btn">Redefinir Palavra-passe</a></center>

            <p style="margin-top:20px;">Se não foste tu a solicitar, podes ignorar este e-mail.</p>
            <p>Obrigado por escolheres a <strong>Limpeza Pro</strong>!</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Limpeza Pro. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>