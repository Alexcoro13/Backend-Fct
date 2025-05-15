<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Correo Electrónico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #666666;
            line-height: 1.6;
        }
        .button {
            background-color: #F0C470;
            color: #ffffff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #aaaaaa;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="{{asset('images/email-logo1.svg')}}" alt="Logo" class="logo">
    <h1>Verify your email address</h1>
    <p>Thanks for signing up! Just one more step to activate your account. Click the button below to verify your email address.</p>
    <a href="{{ $url }}" class="button">Verify my email</a>
    <p class="footer">If you didn't create this account, you can ignore this message. This request will expire in 24 hours.</p>
</div>
</body>
</html>
