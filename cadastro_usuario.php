<?php
include 'db.php'; // Conexão com o banco de dados
session_start(); // Inicia a sessão

// Verifica se o método é POST (caso o formulário tenha sido enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirma_senha) {
        $erro = "As senhas não coincidem!";
    } else {
        // Criptografa a senha antes de salvar no banco de dados
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepara e executa a inserção de dados no banco de dados
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        if ($stmt->execute([$nome, $email, $senha_hash])) {
            // Usuário cadastrado com sucesso
            $_SESSION['user_id'] = $pdo->lastInsertId(); // Armazena o ID do novo usuário
            header("Location: perfil.php"); // Redireciona para o perfil
            exit();
        } else {
            // Erro ao cadastrar
            $erro = "Erro ao cadastrar usuário. Tente novamente!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        /* Estilos do formulário */
        body {
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #444;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 20px;
        }

        .register-container input {
            background-color: #555;
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 10px;
            width: 100%;
            margin: 10px 0;
        }

        .register-container button {
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }

        .register-container button:hover {
            background-color: #e67e22;
        }

        .error {
            color: #e74c3c;
            margin-top: 10px;
        }

        .login-link {
            margin-top: 20px;
            display: block;
            color: #f39c12;
            text-decoration: none;
        }

        .login-link:hover {
            color: #e67e22;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Cadastro</h2>

        <!-- Exibe mensagem de erro se houver -->
        <?php if (isset($erro)): ?>
            <div class="error"><?= $erro ?></div>
        <?php endif; ?>

        <!-- Formulário de Cadastro -->
        <form action="cadastro_usuario.php" method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="confirma_senha" placeholder="Confirmar Senha" required>
            <button type="submit">Cadastrar</button>
        </form>

        <!-- Link para a tela de login -->
        <a href="login.php" class="login-link">Já tem uma conta? Faça login</a>
    </div>

</body>
</html>
