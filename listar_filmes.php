<?php
header('Content-Type: application/json');
include('conexao.php'); // Inclua seu arquivo de conexão com o banco

$query = "SELECT * FROM filmes";
$result = mysqli_query($con, $query);
$filmes = [];

while ($filme = mysqli_fetch_assoc($result)) {
    $filmes[] = $filme;
}

echo json_encode($filmes);
?>
