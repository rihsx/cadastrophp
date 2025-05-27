<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgb(0 0 0 / 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 1rem;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1.25rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #E36588;
            outline: none;
        }
        button[type="submit"] {
            background-color: #E36588;
            color: white;
            border: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #9A275A;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Cadastro de Usuário</h2>
    <form action="processa_cadastro.php" method="POST" novalidate>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required />

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required />
        
        <button type="submit">Cadastrar</button>
    </form>
</div>
</body>
</html>

