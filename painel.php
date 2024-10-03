<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpage com Pesquisa e Grade de Filmes</title>
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
        .search-icon {
            position: absolute;
            margin-left: -30px;
            color: #888;
            font-size: 20px;
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

        /* Estilo da modal */
        .modal {
            display: none; /* Escondido por padrão */
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
        input {
            margin-top: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
        }
        button {
            margin-top: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
            background-color: #f39c12;
            color: #fff;
            cursor: pointer;
        }
        .register-link {
            color: #f39c12;
            cursor: pointer;
            text-decoration: underline;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Modal de Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('loginModal')">&times;</span>
            <video id="movieTrailer" width="100%" controls>
                <source id="trailerSource" src="" type="video/mp4">
                Seu navegador não suporta o elemento de vídeo.
            </video>
        </div>
    </div>

    <div class="search-container">
        <input type="text" class="search-box" placeholder="Pesquisar...">
    </div>

    <div class="grid-container">
        <div class="grid-item" onclick="openModal('loginModal', 'jumanji')">
            <img src="img/jumanji.jpg" alt="Filme 1">
            <h3>Jumanji</h3>
            <p>Quatro estudantes vão parar dentro de um antigo videogame e precisam vencer uma floresta cheia de perigos se não quiserem ficar presos no jogo para sempre.</p>
            <p class="rating">⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item" onclick="openModal('loginModal','tarot')">
            <img src="img/taro.jpg" alt="Filme 2">
            <h3>O Tarot da morte</h3>
            <p>Um a um, eles enfrentam o destino e terminam em uma corrida contra a morte para escapar do futuro previsto em suas leituras.</p>
            <p class="rating">⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item" onclick="openModal('loginModal','e-assim-que-acaba')">
            <img src="img/é assim que acaba.webp" alt="Filme 3">
            <h3>É assim que acaba</h3>
            <p>Lily Bloom decide começar uma nova vida em Boston e tentar abrir o seu próprio negócio. Como consequência de sua mudança de vida, Lily acredita que encontrou o amor verdadeiro com Ryle, um charmoso neurocirurgião.</p>
            <p class="rating">⭐️⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item" onclick="openModal('loginModal','ta-chovendo-hamburguer')">
            <img src="img/chovendo hamburguer.webp" alt="Filme 4">
            <h3>Tá chovendo hambúrguer</h3>
            <p>Flint Lockwood é um jovem cientista que sonha criar algo que faça com que seja reconhecido pelo povo de Boca Grande, uma pequena ilha no Atlântico onde vive. Um dia, ele cria uma máquina capaz de transformar água em comida, mas precisa de bastante eletricidade para colocá-la em funcionamento. Ao tentar usar a energia da geradora local, ele perde o controle da invenção, que ruma para o céu.</p>
            <p class="rating">⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item" onclick="openModal('loginModal','raya-e-o-ultimo-dragao')">
            <img src="img/raya.jpg" alt="Filme 5">
            <h3>Raya e o último dragão</h3>
            <p>Há muito tempo, no mundo de fantasia de Kumandra, humanos e dragões viviam juntos em harmonia. Mas quando uma força maligna ameaçou a terra, os dragões se sacrificaram para salvar a humanidade. Agora, 500 anos depois, o mesmo mal voltou e cabe a uma guerreira solitária, Raya, rastrear o lendário último dragão para restaurar a terra despedaçada e seu povo dividido.</p>
            <p class="rating">⭐️⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item" onclick="openModal('loginModal','fale-comigo')">
            <img src="img/fale comigo.webp" alt="Filme 6">
            <h3>Fale comigo</h3>
            <p>Mia é uma jovem de 17 anos, no aniversário de morte da genitora, a jovem decide se reunir com os amigos, que prometem uma noite diferente.</p>
            <p class="rating">⭐️⭐️</p>
        </div>
        <div class="grid-item" onclick="openModal('loginModal','transformers')">
            <img src="img/250px-Transformers-poster.jpg" alt="Filme 7">
            <h3>Transformers</h3>
            <p>O filme segue a história de Sam Witwicky, que se torna aliado dos Autobots na batalha contra os Decepticons para proteger a AllSpark, uma poderosa fonte de energia. Este filme foi revolucionário para a época, especialmente pelos efeitos especiais.</p>
            <p class="rating">⭐️⭐️⭐️⭐️</p>
        </div>
    </div>

    <script>
        const trailers = {
            jumanji: "filmes/Jumanji.mp4",
            tarot: "filmes/O TARÔ DA MORTE.mp4",
            "e-assim-que-acaba": "filmes/É ASSIM QUE ACABA.mp4",
            "ta-chovendo-hamburguer": "filmes/Tá Chovendo Hambúrguer.mp4",
            "raya-e-o-ultimo-dragao": "filmes/Raya e O Último Dragão.mp4",
            "fale-comigo": "filmes/FALE COMIGO.mp4",
            transformers: "filmes/Transformers.mp4"
        };

        function openModal(modalId, movie) {
            const trailerSource = document.getElementById("trailerSource");
            trailerSource.src = trailers[movie];
            document.getElementById("movieTrailer").load(); // Carrega o novo trailer
            document.getElementById(modalId).style.display = "block";
        }


        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Fecha a modal ao clicar fora dela
        window.onclick = function(event) {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            if (event.target === loginModal) {
                closeModal('loginModal');
            }
            if (event.target === registerModal) {
                closeModal('registerModal');
            }
        }      
    </script>
</body>
</html>
