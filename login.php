<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado, redireciona para outra página se estiver
if (isset($_SESSION['user_id'])) {
    header("Location: perfil.php"); // Redireciona para o perfil ou página inicial
    exit();
}

include 'db.php'; // Inclui o arquivo de conexão com o banco de dados

// Inicializa as variáveis de erro e sucesso
$error = '';
$success = '';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe as informações do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta para buscar o usuário no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Armazena o ID do usuário na sessão
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nome'];
        $_SESSION['user_email'] = $usuario['email'];

        // Redireciona o usuário para o perfil ou outra página
        header("Location: perfil.php");
        exit();
    } else {
        // Se o login falhar, exibe uma mensagem de erro
        $error = 'Email ou senha inválidos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #444;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #333;
            color: white;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #e67e22;
        }

        .error {
            color: #e74c3c;
            text-align: center;
        }

        .success {
            color: #2ecc71;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Digite seu e-mail" required>
            <input type="password" name="senha" placeholder="Digite sua senha" required>
            <button type="submit">Entrar</button>
        </form>

        <div style="margin-top: 20px; text-align: center;">
            <a href="cadastro_usuario.php" style="color: #f39c12;">Ainda não tem uma conta? Cadastre-se aqui</a>
        </div>
    </div>
</body>
</html>
