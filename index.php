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
        .search-box + .search-icon {
            position: absolute;
            margin-left: -30px;
            color: #888;
        }
        .search-box + .search-icon {
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
    </style>
</head>
<body>
    <div class="search-container">
        <input type="text" class="search-box" placeholder="Pesquisar...">
        <span class="search-icon">🔍</span>
    </div>

    <div class="grid-container">
        <div class="grid-item">
            <img src="img/jumanji.jpg" alt="Filme 1">
            <h3>Jumanji</h3>
            <p>Quatro estudantes vão parar dentro de um antigo videogame e precisam vencer uma floresta cheia de perigos se não quiserem ficar presos no jogo para sempre.</p>
            <p class="rating">⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="img/taro.jpg" alt="Filme 2">
            <h3>O Tarot da morte</h3>
            <p>Um a um, eles enfrentam o destino e terminam em uma corrida contra a morte para escapar do futuro previsto em suas leituras.</p>
            <p class="rating">⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="img/é assim que acaba.webp" alt="Filme 3">
            <h3>É assim que acaba</h3>
            <p>Lily Bloom decide começar uma nova vida em Boston e tentar abrir o seu próprio negócio. Como consequência de sua mudança de vida, Lily acredita que encontrou o amor verdadeiro com Ryle, um charmoso neurocirurgião.</p>
            <p class="rating">⭐️⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="img/chovendo hamburguer.webp" alt="Filme 4">
            <h3>Tá chovendo hambúrguer</h3>
            <p>Flint Lockwood é um jovem cientista que sonha criar algo que faça com que seja reconhecido pelo povo de Boca Grande, uma pequena ilha no Atlântico onde vive. Um dia, ele cria uma máquina capaz de transformar água em comida, mas precisa de bastante eletricidade para colocá-la em funcionamento. Ao tentar usar a energia da geradora local, ele perde o controle da invenção, que ruma para o céu</p>
            <p class="rating">⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="img/raya.jpg" alt="Filme 5">
            <h3>Raya e o último dragão</h3>
            <p>Há muito tempo, no mundo de fantasia de Kumandra, humanos e dragões viviam juntos em harmonia. Mas quando uma força maligna ameaçou a terra, os dragões se sacrificaram para salvar a humanidade. Agora, 500 anos depois, o mesmo mal voltou e cabe a uma guerreira solitária, Raya, rastrear o lendário último dragão para restaurar a terra despedaçada e seu povo dividido.</p>
            <p class="rating">⭐️⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="https://via.placeholder.com/300x200" alt="Filme 6">
            <h3>Fale comigo</h3>
            <p>Mia é uma jovem de 17 anos, no aniversário de morte da genitora, a jovem decide se reunir com os amigos, que prometem uma noite diferente.</p>
            <p class="rating">⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="https://via.placeholder.com/300x200" alt="Filme 7">
            <h3>Transformers</h3>
            <p>O filme segue a história de Sam Witwicky, que se torna aliado dos Autobots na batalha contra os Decepticons para proteger a AllSpark, uma poderosa fonte de energia. Este filme foi revolucionário para a época, especialmente pelos efeitos especiais inovadores e cenas de ação impressionantes.</p>
            <p class="rating">⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="https://via.placeholder.com/300x200" alt="Filme 8">
            <h3>Oito mulheres e um segredo</h3>
            <p>Recém-saída da prisão, Debbie Ocean logo procura sua ex-parceira Lou para realizar um elaborado assalto: roubar um colar de diamantes no valor de 150 milhões de dólares, que a empresa Cartier mantém em um cofre. O plano é convencer a organização a emprestá-lo para que a estrela Daphne Kluger use a joia no badalado Met Gala, um dos eventos mais chiques e vistosos de Nova York. Para tanto, Debbie e Lou reúnem uma equipe composta apenas por mulheres: Nine Ball, Amita, Constance, Rose e Tammy.</p>
            <p class="rating">⭐️⭐️⭐️⭐️⭐️</p>
        </div>
        <div class="grid-item">
            <img src="https://via.placeholder.com/300x200" alt="Filme 9">
            <h3>Todos menos você</h3>
            <p>Bea e Ben têm um primeiro encontro incrível, mas a atração inicial logo se torna ódio mútuo. Um casamento na Austrália força a aproximação dos dois, que decidem fingir um relacionamento para enganar a família e os amigos.</p>
            <p class="rating">⭐️⭐️⭐️⭐️⭐️</p>
        </div>
    </div>
</body>
</html>
