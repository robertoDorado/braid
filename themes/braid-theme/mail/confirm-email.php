<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de e-mail Braid.pro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #000000;
            border-radius: 5px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #777;
        }

        .confirmation-message {
            font-size: 24px;
            margin-top: 20px;
        }

        .btn-container {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff2c2c;
            color: #fff;
            text-decoration: none;
            border-radius: 1px;
            transition: background-color 0.3s;
        }

        .logo {
            width: 250px;
        }

        .btn:hover {
            background-color: #000000;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://clientes.laborcode.com.br/braid/themes/braid-theme/assets/img/logo-2-rbg.png" alt="logo" class="logo">
        <h1>Confirmação de E-mail</h1>
        <p>Olá {{ name }} Obrigado por se inscrever! Seu e-mail {{ email }} precisa ser confirmado
        antes de continuar o seu login.</p>
        <p class="confirmation-message">Após a confirmação do e-mail 
            você poderá utilizar o sistema normalmente.</p>
        <div class="btn-container">
            <a href="{{ link }}" class="btn" style="color:#ffffff;">Confirmar e-mail agora mesmo!</a>
        </div>
    </div>
</body>
</html>
