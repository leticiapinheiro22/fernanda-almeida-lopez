<?php
include('conexao.php'); // Inclua seu arquivo de conexão com o banco

$id = $_GET['id']; // Obtenha o ID do filme a ser excluído

$query = "DELETE FROM filmes WHERE id = ?";
$stmt = $pdo->prepare($query); // Use $pdo em vez de $con
$stmt->execute([$id]); // Execute a consulta passando o ID

header("Location: gerenciador.php");
?>
