<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulação de Entrevista</title>
    <link rel="stylesheet" href="css/entrevista.css">
</head>
<?php
include('header_candidato.php');
?>

<body>

    <div class="container">
        <div id="intro">
            <h1>Simulação de Entrevista</h1>
            <p>Escolha o perfil de entrevistador abaixo para começar:</p>
            <select id="perfil">
                <option value="1">Entrevistador Formal</option>
                <option value="2">Entrevistador Amigável</option>
                <option value="3">Entrevistador Técnico</option>
                <option value="4">Entrevistador Desafiador</option>
            </select>
            <button onclick="iniciarEntrevista()">Iniciar Entrevista</button>
        </div>

        <div id="perguntas">
            <h2>Perguntas da Entrevista</h2>
            <p id="perguntaAtual"></p>
            <textarea id="resposta" rows="4" placeholder="Escreva sua resposta aqui..."></textarea>
            <button class="iniciar" id="" onclick="proximaPergunta()">Próxima Pergunta</button>
        </div>

        <div id="resultado">
            <h2>Resultado</h2>
            <div id="feedback"></div>
            <button id="reiniciar" onclick="reiniciar()">Refazer Entrevista</button>
        </div>
    </div>

    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

    <script>
        function openMenu() {
            document.getElementById("side-menu").style.width = "250px";
        }

        function closeMenu() {
            document.getElementById("side-menu").style.width = "0";
        }

        document.getElementById("menu-btn").onclick = openMenu;
    </script>
    <script src="js/notificacao.js"></script>

    <script src="js/script.js"></script>
</body>

</html>