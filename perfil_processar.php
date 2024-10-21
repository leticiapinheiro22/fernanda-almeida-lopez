<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redireciona para o login se o usuário não estiver logado
    exit();
}

$user_id = $_SESSION['user_id'];

// Busca os dados do usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Atualizar usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['atualizar'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Atualiza o nome e o e-mail, e só atualiza a senha se foi fornecida
        if (!empty($senha)) {
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $senha, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $user_id]);
        }

        exibirMensagem('Dados atualizados com sucesso!');
        header("Location: perfil.php"); // Redireciona após atualizar os dados
        exit();
    }

    // Excluir conta
    if (isset($_POST['excluir'])) {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$user_id]);

        // Apaga a sessão e redireciona para o login
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
