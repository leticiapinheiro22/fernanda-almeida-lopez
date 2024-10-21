<?php
include 'conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];
    $classificacao = $_POST['classificacao'];
    
    // Verifica se um ID foi passado para atualização
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        // Atualiza o filme
        $query = $pdo->prepare("UPDATE filmes SET titulo = :titulo, descricao = :descricao, imagem = :imagem, classificacao = :classificacao WHERE id = :id");
        $query->execute([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'imagem' => $imagem,
            'classificacao' => $classificacao,
            'id' => $id
        ]);
        header("Location: gerenciador.php"); // Redireciona para a página de gerenciador
        exit;
    } else {
        // Cadastra um novo filme
        $query = $pdo->prepare("INSERT INTO filmes (titulo, descricao, imagem, classificacao) VALUES (:titulo, :descricao, :imagem, :classificacao)");
        $query->execute([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'imagem' => $imagem,
            'classificacao' => $classificacao
        ]);
        header("Location: gerenciador.php"); // Redireciona para a página de gerenciador
        exit;
    }
}
?>
