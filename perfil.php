<?php
include 'db.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para a página de login caso não esteja logado
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Busca os dados do usuário no banco de dados
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Se o usuário não existir, redireciona para a página de login
if (!$usuario) {
   header("Location: login.php");
   exit();
}

// Função para exibir mensagens de erro ou sucesso
function exibirMensagem($mensagem) {
    echo "<script>alert('$mensagem');</script>";
}

// Processa o envio do formulário para atualizar o perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['atualizar'])) {
        // Atualizar o perfil
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        // Verifica se o campo da nova senha não está vazio
        if (!empty($senha)) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a nova senha
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $senha_hash, $user_id]);
            header("Location: perfil.php");
        } else {
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $user_id]);
            header("Location: perfil.php");
        }
    } elseif (isset($_POST['excluir'])) {
        // Excluir conta
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        if ($stmt->execute([$user_id])) {
            // Deleta a sessão e redireciona para o login
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            exibirMensagem("Erro ao excluir conta. Tente novamente.");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <style>
        body {
            background-color: #333; /* Cinza escuro */
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* Estilo da barra de pesquisa */
        .search-container {
            margin-top: 20px;
        }
        .search-box {
            background-color: #444;
            border: none;
            border-radius: 25px;
            padding: 10px;
            width: 300px;
            color: #fff;
            font-size: 16px;
            display: flex;
            align-items: center;
            outline: none;
        }
        .search-box::placeholder {
            color: #888;
        }

        /* Estilo da grade de filmes */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 20px;
        }
        .grid-item {
            background-color: #444;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            color: #fff;
            cursor: pointer;
        }
        .grid-item img {
            width: 100%;
            height: 500px;
            border-bottom: 2px solid #555;
        }
        .grid-item h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .grid-item p {
            margin: 10px;
            font-size: 14px;
        }
        .grid-item .rating {
            font-size: 16px;
            color: #f39c12;
        }

        /* Estilo da modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #444;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            border-radius: 10px;
            color: #fff;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilo do botão flutuante */
        .floating-btn {
            position: fixed;
            top: 20px;
            left: 95%;
            background-color: #f39c12;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 15px;
            font-size: 24px;
            cursor: pointer;
            z-index: 1000;
        }

        /* Estilo do menu lateral */
        .side-menu {
            position: fixed;
            top: 0;
            left: -250px; /* Inicialmente fora da tela */
            width: 250px;
            height: 100%;
            background-color: #444;
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.5);
            transition: left 0.3s ease;
            padding: 20px;
            color: white;
        }
        .side-menu ul {
            list-style: none;
            padding: 0;
        }
        .side-menu ul li {
            margin: 20px 0;
            font-size: 18px;
        }
        .side-menu ul li a {
            color: white;
            text-decoration: none;
        }
        .side-menu ul li a:hover {
            color: #f39c12;
        }

        /* Botão para fechar o menu lateral */
        .side-menu .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        /* Faz o botão de fechar desaparecer quando o menu está fechado */
        .side-menu.closed .close-menu {
            display: none;
        }
    </style>
    <style>
        /* Estilos semelhantes ao que você já usou */
        body {
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-container {
            background-color: #444;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            width: 300px;
            text-align: center;
        }

        .profile-container h2 {
            margin-bottom: 20px;
        }

        .profile-container input {
            background-color: #555;
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 10px;
            width: 100%;
            margin: 10px 0;
        }

        .profile-container button {
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            margin: 10px 0;
        }

        .profile-container button:hover {
            background-color: #e67e22;
        }

        .delete-account {
            background-color: #e74c3c;
        }

        .delete-account:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <!-- Botão flutuante de configuração -->
    <button class="floating-btn" onclick="toggleMenu()">⚙️</button>

    <!-- Menu Lateral -->
    <div id="sideMenu" class="side-menu closed">
        <span class="close-menu" onclick="toggleMenu()">×</span>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="painel.php">Painel</a></li>
            <li><a href="cadastro_usuario.php">Cadastro de usuario</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </div>

    <div class="profile-container">
        <h2>Perfil do Usuário</h2>
        <form action="perfil.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            <input type="email" name="email" placeholder="E-mail" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            <input type="password" name="senha" placeholder="Nova Senha (deixe em branco para não alterar)">
            <button type="submit" name="atualizar">Atualizar</button>
        </form>

        <!-- Excluir conta -->
        <form action="perfil.php" method="POST">
            <button type="submit" name="excluir" class="delete-account">Excluir Conta</button>
        </form>
    </div>

    <script>
        // Função para alternar o menu lateral
        function toggleMenu() {
            const menu = document.getElementById('sideMenu');
            const closed = menu.classList.contains('closed');
            if (closed) {
                menu.style.left = '0';
                menu.classList.remove('closed');
            } else {
                menu.style.left = '-250px';
                menu.classList.add('closed');
            }
        }
    </script>
</body>
</html>
