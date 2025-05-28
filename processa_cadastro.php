<?php

$host = 'localhost';
$usuario = 'root'; 
$senha = ''; 
$banco = 'seubanco'; 


function exibeMensagem($mensagem, $sucesso = true) {
    $cor = $sucesso ? '#28a745' : '#dc3545';
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Resultado do Cadastro</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f0f2f5;
                display: flex;
                flex-direction: column;
                align-items: center;
                margin: 0;
                padding: 2rem;
            }
            .message-box {
                background: white;
                padding: 2rem 3rem;
                border-radius: 8px;
                box-shadow: 0 2px 12px rgb(0 0 0 / 0.1);
                max-width: 400px;
                width: 100%;
                text-align: center;
                color: $cor;
            }
            a {
                display: inline-block;
                margin-top: 1rem;
                text-decoration: none;
                color: #E36588;
                font-weight: bold;
            }
            a:hover {
                text-decoration: underline;
            }
            h1 {
                text-align: center;
                color: #333;
            }
            table {
                margin: 2rem auto;
                border-collapse: collapse;
                width: 80%;
                max-width: 800px;
                background: white;
                box-shadow: 0 2px 12px rgba(0,0,0,0.1);
                border-radius: 8px;
                overflow: hidden;
            }
            thead {
                background-color: #E36588;
                color: white;
                text-align: left;
            }
            th, td {
                padding: 12px 15px;
                border-bottom: 1px solid #ddd;
            }
            tbody tr:hover {
                background-color: #f1f7ff;
            }
            tbody tr:last-child td {
                border-bottom: none;
            }
            .no-data {
                text-align: center;
                padding: 2rem;
                color: #666;
            }
        </style>
    </head>
    <body>
    <div class="message-box">
        <h2>$mensagem</h2>
        <a href="cadastro_usuario.php">Voltar para cadastro</a>
    </div>
HTML;

    
    global $host, $usuario, $senha, $banco;
    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        echo "<p class='no-data'>Erro ao conectar ao banco de dados: " . $conn->connect_error . "</p>";
        echo "</body></html>";
        exit;
    }

    $sql = "SELECT id, nome, email FROM usuarios ORDER BY id DESC";
    $result = $conn->query($sql);

    echo "<h1>Usuários Cadastrados</h1>";
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['nome']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-data'>Nenhum usuário cadastrado até o momento.</p>";
    }

    $conn->close();
    echo "</body></html>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    if (empty($nome) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exibeMensagem('Nome ou email inválido.', false);
    }

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        exibeMensagem('Erro ao conectar ao banco de dados: ' . $conn->connect_error, false);
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    if (!$stmt) {
        exibeMensagem('Erro na preparação da consulta: ' . $conn->error, false);
    }

    $stmt->bind_param("ss", $nome, $email);

    if ($stmt->execute()) {
        exibeMensagem('Usuário cadastrado com sucesso!');
    } else {
        exibeMensagem('Erro ao cadastrar usuário: ' . $stmt->error, false);
    }

    $stmt->close();
    $conn->close();
} else {
    // Se acessado por GET ou outro método
    header('Location: cadastro_usuario.php');
    exit;
}
?>
