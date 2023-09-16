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
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmação de E-mail</h1>
        <p>Olá {{ name }} Obrigado por se inscrever! Seu e-mail {{ email }} precisa ser confirmado
        antes de continuar o seu login.</p>
        <p class="confirmation-message">Apos a confirmação do e-mail 
            você poderá utilizar o sistema normalmente.</p>
        <div class="btn-container">
            <a href="#" class="btn" style="color:#ffffff;">Confirmar e-mail agora mesmo!</a>
        </div>
    </div>
</body>
</html>
