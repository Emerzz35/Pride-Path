<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verificação de Email - Pride Path</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .verification-code {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 5px;
            margin: 30px 0;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/logo/LOGOTIPO-PRIDEPATH.svg') }}" alt="Pride Path Logo" class="logo">
            <h2>Verificação de Email</h2>
        </div>
        
        <p>Olá,</p>
        
        <p>Obrigado por se registrar no Pride Path! Para completar seu cadastro, por favor utilize o código de verificação abaixo:</p>
        
        <div class="verification-code">{{ $verificationCode }}</div>
        
        <p>Este código é válido por 30 minutos. Se você não solicitou este código, por favor ignore este email.</p>
        
        <p>Atenciosamente,<br>Equipe Pride Path</p>
        
        <div class="footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p>&copy; {{ date('Y') }} Pride Path. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
