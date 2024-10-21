<?php
session_start(); // Inicia a sessão

// Destrói todas as variáveis de sessão
$_SESSION = array(); 

// Se houver um cookie de sessão, destrua-o também
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
              $params["path"], 
              $params["domain"], 
              $params["secure"], 
              $params["httponly"]);
}

// Finalmente, destrua a sessão
session_destroy();

// Redireciona o usuário para a página de login ou página inicial
header("Location: login.php");
exit();
?>
