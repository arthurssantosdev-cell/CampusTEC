<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Currículo</title>
    <link rel="stylesheet" href="css/curriculo.css">
</head>
<?php
include('header_candidato.php');
?>

<body>

    <div class="formulario">
        <div class="main-curriculo">
            <h1>Criação de Currículo</h1>
            <form id="curriculoForm" method="post">
                <input type="text" id="nome" name="nome" placeholder="Nome" required><br><br>
                <input type="email" id="email" name="email" placeholder="Email" required><br><br>
                <input type="tel" id="telefone" name="telefone" placeholder="Telefone" required maxlength="15"
                    required><br><br>
                <input type="text" id="endereco" name="endereco" placeholder="Endereço" required><br><br>
                <textarea id="experiencia" name="experiencia" placeholder="Experiência Profissional"
                    required></textarea><br><br>
                <textarea id="habilidades" name="habilidades" placeholder="Habilidades" required></textarea><br><br>
                <textarea id="formacao" name="formacao" placeholder="Formação Acadêmica" required></textarea><br><br>
                <label for="imagem">Sua foto (Opcional)</label>
                <input type="file" id="imagem" name="imagem" accept="image/*"><br><br>
                <button type="button" class="botaoCurriculo" id="botaoCurriculo" onclick="gerarPDF()">Gerar PDF</button>
            </form>
        </div>
    </div>
    <footer id="footer">
        <p>&copy; 2024 CampusTec. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
    <script src="js/curriculo.js"></script>

</body>

</html>