<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Filmes</title>
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

        .side-menu {
            position: fixed;
            top: 0;
            left: -250px;
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

        .side-menu .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .side-menu.closed .close-menu {
            display: none;
        }
        .form-container {
            margin-top: 20px;
            background-color: #444;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #555;
            color: white;
        }
        .form-group textarea {
            resize: none;
        }
        .submit-btn {
            background-color: #f39c12;
            border: none;
            padding: 10px;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>


<?php
include 'conexao.php';

// Função para buscar filmes
function listarFilmes($pdo) {
    $query = $pdo->query("SELECT * FROM filmes");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar um filme por ID
function buscarFilmePorId($pdo, $id) {
    $query = $pdo->prepare("SELECT * FROM filmes WHERE id = :id");
    $query->execute(['id' => $id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// Verifica se um ID foi passado para edição
$filmeEditando = null;
if (isset($_GET['id'])) {
    $filmeEditando = buscarFilmePorId($pdo, $_GET['id']);
}

// Listar todos os filmes
$filmes = listarFilmes($pdo);
?>

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
            <li><a href="#">Sair</a></li>
        </ul>
    </div>

    <div class="form-container">
        <h2><?php echo $filmeEditando ? 'Editar Filme' : 'Cadastrar Filme'; ?></h2>
        <form method="POST" action="cadastrar_filme.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $filmeEditando ? $filmeEditando['id'] : ''; ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $filmeEditando ? htmlspecialchars($filmeEditando['titulo']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required><?php echo $filmeEditando ? htmlspecialchars($filmeEditando['descricao']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem (URL):</label>
                <input type="text" id="imagem" name="imagem" value="<?php echo $filmeEditando ? htmlspecialchars($filmeEditando['imagem']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="classificacao">Classificação:</label>
                <input type="number" id="classificacao" name="classificacao" min="1" max="5" value="<?php echo $filmeEditando ? $filmeEditando['classificacao'] : ''; ?>" required>
            </div>
            <button type="submit" class="submit-btn"><?php echo $filmeEditando ? 'Atualizar Filme' : 'Cadastrar Filme'; ?></button>
        </form>
    </div>

    <div class="grid-container" id="filmesList">
        <?php if (count($filmes) > 0): ?>
            <?php foreach ($filmes as $filme): ?>
                <div class="grid-item">
                    <img src="<?php echo htmlspecialchars($filme['imagem']); ?>" alt="Imagem do filme">
                    <h3><?php echo htmlspecialchars($filme['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($filme['descricao']); ?></p>
                    <p class="rating">Classificação: <?php echo htmlspecialchars($filme['classificacao']); ?></p>
                    <button onclick="editarFilme(<?php echo $filme['id']; ?>)">Editar</button>
                    <button onclick="excluirFilme(<?php echo $filme['id']; ?>)">Excluir</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum filme cadastrado.</p>
        <?php endif; ?>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('sideMenu');
            const closed = menu.classList.contains('closed');
            menu.style.left = closed ? '0' : '-250px';
            menu.classList.toggle('closed');
        }

        function editarFilme(id) {
            window.location.href = '?id=' + id;
        }

        function excluirFilme(id) {
            if(confirm('Tem certeza que deseja excluir?')) {
                window.location.href = 'excluir_filme.php?id=' + id;
            }
        }
    </script>

</body>
</html>
